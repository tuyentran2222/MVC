<?php
	namespace core;
	
	class Response{
		/**
		 * @desc set status code of response
		 * @return void
		 */
		public function setStatusCode(int $code){
			http_response_code($code);
		}

		/**
		 * @desc redirect to $url
		 * @param string $url
		 * @return void
		 */
		public function redirect($url){
			return header("Location:" .$url);
		}

		/**
		 * @desc refresh current page
		 * @return void
		 */
		public function refresh(){
			return header('Location: '.Server::getServerByKey('REQUEST_URI'));
		}
	}