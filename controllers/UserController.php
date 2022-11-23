<?php
	namespace controllers;
	
	use core\Application;
	use core\Controller;
	use core\Request;
	use helper\File;
	use models\User;

	class UserController extends Controller{
		/**
		 * @desc show account info
		 */
		public function show(Request $request){
			$user = Application::getSession("user");
			$user = User::findOne(["email" => $user->email]);
			$user->password = "";
			return $this->render("account", ["user" => $user, "popup" => false], "account");
		}

		/**
		 * @desc update account info
		 */
		public function update(Request $request){
			$body = $request->getBody();
			$current_user = Application::getSession("user");
			$user = User::findOne(["email" => $current_user->email]);
			$user->loadData($body);

			$update_user_rules = [
				"first_name" => [User::RULE_REQUIRED],
				"last_name" => [User::RULE_REQUIRED],
				"company" => [User::RULE_REQUIRED],
				"job_title" => [User::RULE_REQUIRED]
			];
			if (!$user->validateRules($update_user_rules)){
				$user->password = "";
				Application::setFlashSession("notify", ["message" =>"Error: Some field is empty" , "status" => "false"]);
				return $this->render("account", ["user" => $user, 'popup' => true], "account");
			}

			if (!$user->save()){
				return Application::redirect("account");
			}

			Application::setFlashSession("notify", ["message" =>"Update user successfully." ,"status" => "success"]);
			return Application::redirect("/account");
		}

		/**
		 * @desc update avatar image
		 */
		public function updateAvatar(Request $request){
			$user = Application::getSession("user");
			$file = $request->hasFile("avatar");
			$allowed_file_extensions = array("jpg", "gif", "png", "jpeg");
			$upload_file_dir = "avatar/";
			try{
				if (!$file) throw new \Exception("No File Exists");
				$file_size = $file["size"] / 1024 / 1024;
				$size_file_max =  $_ENV["UPLOAD_MAX_FILE_SIZE"];
				$file_name = $file["name"];
				$file_name_cmps = explode(".", $file_name);
				$file_extension = strtolower(end($file_name_cmps));
				if (!in_array($file_extension, $allowed_file_extensions)){
					throw new \Exception("Not Allowed File Extensions");
				}
				if ($file_size > $_ENV["UPLOAD_MAX_FILE_SIZE"]){
					throw new \Exception("File not allowed exceed $size_file_max MB");
				}
				$new_file_name = $user->id;
				File::deleteFile($user->avatar);
				$dest_path = File::uploadFile($file, $upload_file_dir, $new_file_name);
				if (!$dest_path){
					Application::setFlashSession("notify", ["message" => "Something went error" ,"status" => "error"]);
					return Application::redirect("/account");
				}
				User::update(["avatar" => $dest_path ], ["email" => $user->email]);
				$user->avatar = $dest_path;
				Application::setFlashSession("notify", ["message" => "Update avatar successfully.", "status" => "success"]);
				return Application::redirect("account");
			}
			catch (\Exception $e){
				Application::setFlashSession("notify", ["message" => $e->getMessage(), "status" => "error"]);
				Application::redirect("account");
			}
		}
	}