<?php
	namespace controllers;

	use core\Application;
	use core\Controller;
	use core\Request;
	use models\User;
	use helper\Email;
	use helper\ReCaptcha;
	use helper\StringHelper;

	use models\Session;

	class AuthController extends Controller{
	
		public function login($request){
			$body = $request->getBody();
			$remember = $body["remember"] ?? false;
			
			// handle recaptcha
			$failed_attempt_login = Application::getSession("failed_attempt_login");
			$recaptcha = $body["g-recaptcha-response"] ?? "";
			$valid_captcha = $this->validCaptcha($recaptcha, $failed_attempt_login);
			if (!$valid_captcha){
				Application::setSession("failed_attempt_login", $failed_attempt_login + 1);
				Application::setFlashSession("notify", ["message" => "Please click on recaptcha before login", "status" => "error"]);
				return $this->render("login");
			}

			$current_user = User::fromData($body);
			$rules = [
				"email" => [ User::RULE_REQUIRED, User::RULE_EMAIL],
				"password" => [User::RULE_REQUIRED, [User::RULE_MIN, "min" => 6], [User::RULE_MAX, "max" => 30]],
			];

			if (!$current_user->validateRules($rules)){
				$current_user->password = "";
				Application::$app->setSession("failed_attempt_login", $failed_attempt_login + 1);
				return $this->render("login", ["user" => $current_user]);
			}

			$user = User::findOne(["email" => $body["email"]]);
			if (!$user){
				$current_user->password = "";
				Application::setSession("failed_attempt_login", $failed_attempt_login + 1);
				Application::setFlashSession("notify", ["message" => "It's look like you're not yet a member! Click on the bottom link to signup", "status" => "error"]);
				return $this->render("login", ["user" => $current_user]);
			}

			if (!password_verify($current_user->password, $user->password)){
				$current_user->password = "";
				Application::setSession("failed_attempt_login", $failed_attempt_login + 1);
				Application::setFlashSession("notify", ["message" => "Email or password is incorrect. Please try again", "status" => "error"]);
				return $this->render("login", ["user" => $current_user]);
			}
			$user->password = "";
			if (!$user->active){
				Application::setFlashSession("notify", ["message" => "It's look like you have't still verify your email", "status" => "success"]);
				Application::setSession("email", $user->email);
				return Application::$app->response->redirect("/verifyCode");
			}
			Application::setFlashSession("notify",["message" => "Login successfully", "status" => "success"]);
			if ($remember){
				$this->rememberMe($user);
			}
			Application::setSession("user", $user);
			Application::setSession("failed_attempt_login", 0);
			return Application::$app->response->redirect("/account");
		}

		public function register(Request $request){
			$body = $request->getBody();
			$user = User::fromData($body);

			if (!$user->validate()){
				return $this->render("register", ["user" => $user]);
			}

			$user->setPassword($user->password);
			$user->generateConfirmCode();
			$user->save();

			$receiver = $user->email;
			$subject = "Base Account Code";
			$body = "Your code to verify account: ".$user->verify_code;
			Email::sendEmail($receiver, $subject, $body);

			Application::setSession("email", $user->email);
			Application::setFlashSession("notify", ["message" => "We\"ve sent otp code to your email: ". $user->email, "status" => "success"]);
			Application::$app->response->redirect("/verifyCode");
		}

		public function verifyCode(Request $request){
			$email = Application::getSession("email");
			$user = User::findOne(["email" => $email]);
			$body = $request->getBody();
			$key = "verify_code";
			if ($user->active){
				$key = "reset_password_code";
			}

			$$key = $body["verify_code"] ?? "";
			$search = ["email" => $email, $key => $$key];

			$user = User::findOne($search);
			if (!$user || !$$key){
				Application::setFlashSession("notify", ["message" => "You've entered incorrect code!", "status" => "error"]);
				return $this->render("verifyCode");
			}

			if (!User::update([$key => "", "active" => 1], ["email" => $email])){
				Application::setFlashSession("notify", ["message" => "Something went wrong. Please try again". $email, "status" => "error"]);
				return $this->render("verifyCode");
			}
			Application::setFlashSession("notify", ["message" => "Login successfully", "status" => "success"]);
			Application::setSession("user", $user);
			if (!Application::getSession("forgetPassword")){
				Application::$app->session->unsetSession("email");
				return Application::$app->response->redirect("/account");
			}
			Application::setFlashSession("notify", ["message" => "Please create a new password that you don't use on any other site.", "status" => "success"]);
			Application::setSession("changePassword", true);
			return Application::$app->response->redirect("/changePassword");
		}

		public function changePassword(Request $request){
			$body = $request->getBody();
			$email = Application::getSession("email");
			$user = User::findOne(["email" => $email]);
			$user->password = $body["password"] ?? "";
			$user->confirm_password = $body["confirm_password"] ?? "";
			$passwordRules = [
				"password" => [User::RULE_REQUIRED, [User::RULE_MIN, "min" => 6], [User::RULE_MAX, "max" => 30]],
				"confirm_password" => [User::RULE_REQUIRED, [User::RULE_MIN, "min" => 6], [User::RULE_MAX,"max" =>30], [User::RULE_MATCH, "match" => "password"]],
			];
			if (!$user->validateRules($passwordRules)){
				$user->password = "";
				$user->confirm_password = "";
				return $this->render("changePassword", ["user" => $user]);
			}

			$user->setPassword($user->password);

			if (!User::update(["password" => $user->password], ["email" => $email] )){
				Application::setFlashSession("notify", ["message" => "Something went wrong. Please try again",  "status" => "error"]);
				return $this->render("changePassword");
			}
			Application::setFlashSession("notify", ["message" => "Change password successfully.",  "status" => "success"]);
			Application::setSession("changePassword", false);
			return Application::$app->response->redirect("/login");
		}

		public function forgetPassword(Request $request){
			$body = $request->getBody();
			$user = User::fromData($body);
			$receiver = $body["email"];

			if (!$user->validateRules(["email" => [ User::RULE_REQUIRED, User::RULE_EMAIL]])){
				return $this->render("verifyCode");
			}

			$user->generateForgetCode();
			if (!User::update(["reset_password_code" => $user->reset_password_code], ["email" => $receiver])){
				Application::setFlashSession("notify",["message" => "Something went wrong. Please try again",  "status" => "error"]);
				return $this->render("forgetPassword");
			}

			Application::setFlashSession("notify", ["message" => "We\"ve sent otp code to your email: ". $user->email,  "status" => "success"]);
			Application::setSession("forgetPassword", true);
			Application::setSession("email", $receiver);

			$subject = "Base Account Code";
			$body = "Your code to change account password : ".$user->reset_password_code;
			Email::sendEmail($receiver, $subject, $body);
			return Application::$app->response->redirect("/verifyCode");
		}

		public function logout(){
			$user = Application::getSession("user");
			if ($user){
				Session::delete(["user_id" => $user->id]);
				Application::$app->cookie->unsetCookie("token");
			}
			
			Application::$app->session->unset();
			Application::setFlashSession("notify", ["message" => "Logout successfully", "status" => "success"]);
			return Application::$app->response->redirect("/login");
		}


		private function validCaptcha($recaptcha, $failed_attempt_login){
			if ($failed_attempt_login < 4) return true;
			if ($failed_attempt_login >= 4 && !ReCaptcha::validateRecaptcha($recaptcha) ) return false;
			return true;
		}

		private function rememberMe($user){
			$days = $_ENV["REMEMBER_DAY"];
			Session::delete(["user_id" => $user->id]);
			$token = new Session();
			$token->user_id = $user->id;
			$token->token = StringHelper::randomString();
			$expired_seconds = time() + 60 * 60 * 24 * $days;
			$token->expiry =  date("Y-m-d H:i:s", $expired_seconds);
			
			if ($token->save()){
				Application::$app->cookie->setCookie("token", $token->token, $expired_seconds);
			}
		}
	}