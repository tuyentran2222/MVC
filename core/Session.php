<?php
	namespace core;

	use helper\StringHelper;

	class Session{
		public const FLASH_KEY = "FLASH_KEY";

		public function __construct(){
			session_start();
			if (!$this->getSession('csrf_token')) $this->setSession('csrf_token', StringHelper::randomString(32));
			if (!$this->getSession('failed_attempt_login')) $this->setSession('failed_attempt_login', 0);
			$flash_messages = $_SESSION[self::FLASH_KEY] ?? [];
			foreach ($flash_messages as $key => &$message){
				unset($message[$key]);
			}
			$_SESSION[self::FLASH_KEY] = $flash_messages;
		}

		/**
		 * @desc set flash session
		 * @param string $key flash session name
		 * @param string $value flash session value
		 * @return void
		 */
		public function setFlashSession($key, $value){
			$_SESSION[self::FLASH_KEY][$key] = [
				"value" => $value
			];
		}

		/**
		 * @desc get flash session by name
		 * @param string $key flash session name
		 * @return mixed
		 */
		public function getFlashSession($key){
			// DONE: Nen xoa luon
			$flash_session = $_SESSION[self::FLASH_KEY][$key]["value"] ?? "";
			unset($_SESSION[self::FLASH_KEY][$key]["value"]);
			return $flash_session;
		}

		/**
		 * @desc set session
		 * @param string $key session name
		 * @param string $value session value
		 * @return void
		 */
		public function setSession($key, $value){
			$_SESSION[$key] = $value;
		}

		/**
		 * @desc get session value by name
		 * @param string $key session name
		 * @return mixed
		 */
		public function getSession($key){
			return $_SESSION[$key] ?? "";
		}

		/**
		 * @desc unset session
		 * @param string $key
		 * @return void
		 */
		public function unsetSession($key){
			unset($_SESSION[$key]);
		}

		/**
		 * @desc unset session
		 * @return void
		 */
		public function unset(){
			session_unset();
		}

		/**
		 * @desc destroy session
		 * @return void
		 */
		public function destroy(){
			session_unset();
		}
	}