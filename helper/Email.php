<?php
	namespace helper;

	class Email{
		/**
		 * @desc validate email
		 * @param string $email
		 * @return boolean return true if email is valid, otherwise return false;
		 */
		public static function isEmail($email){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				return false;
			}
			return true;
		}

		/**
		 * @desc send email
		 * @param string $email email received
		 * @param string $subject email subject
		 * @param string $body email body
		 * @return boolean return true if email was sent successfully, otherwise return false;
		 */
		public static function sendEmail($email, $subject, $body){
			$sender = "From:".$_ENV['SERVER_EMAIL'];
			return mail($email, $subject, $body, $sender);
		}
	}

?>