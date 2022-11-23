<?php
	namespace models;

	use core\DBModel;
	use helper\StringHelper;

	class User extends DBModel{
		const ACTIVE_USER = 1;
		const INACTIVE_USER = 0;

		const DEFAULT_AVATAR = "avatar/defaultAvatar.jpg";
		public $id;
		public $email = "";
		public $password = "";
		public $phone = "";
		public $first_name = "";
		public $last_name;
		public $confirm_password = "";
		public $verify_code = "";
		public $reset_password_code = "";
		public $active = 0;
		public $avatar =  User::DEFAULT_AVATAR;
		public $company = "";
		public $job_title = "";

		public static function tableName(){
			return "users";
		}

		public function attributes(){
			return ["email", "password", "verify_code", "avatar", "first_name", "last_name", "company", "job_title", "reset_password_code", "active"];
		}

		public function getRules() {
			return [
				"first_name" => [self::RULE_REQUIRED],
				"last_name" => [self::RULE_REQUIRED],
				"password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX, "max" => 30]],
				"confirm_password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 6], [self::RULE_MAX,"max" =>30], [self::RULE_MATCH, "match" => "password"]],
				"email" => [ self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, "class" => self::class]]
			];
		}

		// public function release(){
		// 	return (object)[
		// 		"id" => $this->id,
		// 		"first_name" => $this->first_name,
		// 		"last_name" => $this->last_name,
		// 		"avatar" => $this->avatar,
		// 		"company" => $this->company,
		// 		"job_title" => $this->job_title,
		// 		"email" => $this->email,
		// 		"active" => $this->active
		// 	];
		// }

		public function generateConfirmCode(){
			$this->verify_code = StringHelper::randomString(16);
			return $this->verify_code;
		}

		public function setPassword($password){
			$this->password = password_hash($password, PASSWORD_DEFAULT);
		}

		public function generateForgetCode(){
			$this->reset_password_code = StringHelper::randomString(16);
			return $this->reset_password_code;
		}
	}