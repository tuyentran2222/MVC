<?php
	namespace middlewares;

	use core\Application;
	use core\Middleware;
	use models\Session;
	use models\User;
	class AuthMiddleware extends Middleware{
		public function handle($request){
			$token = new Session();
            $tokenValue = Application::$app->cookie->getCookie("token") ?? "";
            if ($token){
                $resToken = $token->getByToken($tokenValue);
                if ($resToken){
                    $user = User::findOne(["id" => $resToken["user_id"] ]);
                    Application::setSession("user", $user);
                    Application::setSession("email", $user->email);
                }
            }
			if (!Application::$app->getSession("user")){
				if ($request->getPath() !== "/login") return Application::redirect("/login");
			}
			else{
				 if ($request->getPath() !== "/account") return Application::redirect("/account");
			}
		}
	}