<?php
	namespace core;

	class Cookie{
		/**
		 * @desc: set cookie
		 * @param string $cookie_key cookie name
		 * @param string $cookie_value cookie value
		 * @param int $cookie_expired default=0
		 * @return boolean return true if set cookie successfully, otherwise return false;
		 */
		public function setCookie($cookie_key, $cookie_value, $cookie_expired=0){
			return setCookie($cookie_key, $cookie_value, $cookie_expired);
		}

		/**
		 * @desc: get cookie value by cookie name
		 * @param string $cookie_key cookie name
		 * @return mixed return cookie value if cookie exists otherwise return "";
		 */
		public function getCookie($cookie_key){
			return $_COOKIE[$cookie_key] ?? "";
		}

		/**
		 * @desc: unset cookie
		 * @param string $cookie_key cookie name
		 * @return void
		 */
		public function unsetCookie($key){
			if (isset($_COOKIE[$key])){
				unset($_COOKIE[$key]);
				setcookie($key, null, -1, '/');
			}
		}
	}

