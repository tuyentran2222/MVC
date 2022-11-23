<?php
	namespace helper;

	class StringHelper{
		/**
		 * @desc generate random string
		 * @param string $length
		 * @return string random string
		 */
		public static function randomString($length=32){
			return bin2hex(random_bytes($length));
		}
	}