<?php
	namespace helper;
	use core\Server;
	class ReCaptcha{
		const RECAPTCHA_VERIFY_URL = "https://www.google.com/recaptcha/api/siteverify";

		/**
		 * @desc: validate captcha
		 * @param string $recaptcha
		 * @return boolean return true if captcha is valid otherwise return false
		 */
		public static function validateRecaptcha($recaptcha){
			$secret_key = $_ENV['RECAPTCHA_SECRET_KEY'];
			$ip = Server::getServerByKey('REMOTE_ADDR');
			$url = self::RECAPTCHA_VERIFY_URL."?secret=" . urlencode($secret_key) .  '&response=' . urlencode($recaptcha). "&remoteip=".$ip;
			$response = file_get_contents($url);
			$data_return = json_decode($response,true);
			return $data_return['success'] ?? false;
		}
	}