<?php
namespace helper;
	class Config{
		/**
		 * @desc get database config
		 * @return array return database config
		 */
		public static function getDBConfig(){
			return [
				"host" => $_ENV["DATABASE_HOST"],
				"dbname" => $_ENV["DATABASE_NAME"],
				"username" => $_ENV["DATABASE_USER"],
				"password" => $_ENV["DATABASE_PASSWORD"]
			];
		}
	}