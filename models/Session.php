<?php
	namespace models;

	use core\Application;
	use core\DBModel;

	class Session extends DBModel{
		public $id;
		public $expiry;
		public $token;
		public $user_id;

		public static function tableName(){
			return "sessions";
		}

		public function attributes(){
			return ["expiry", "token", "user_id"];
		}

		public function getRules(){

		}

		public function getByToken($token){
			$sql = "SELECT * FROM ". static::tableName(). " WHERE token = :token AND expiry > now() LIMIT 1";
			$statement = Application::$app->database->exec($sql, ["token" => $token]);
			return $statement->fetch(\PDO::FETCH_ASSOC);
		}

		public function release(){
	
		}
	}