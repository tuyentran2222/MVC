<?php
	namespace middlewares;

	use core\Application;
	use core\Middleware;
	use exceptions\CsrfException;

	class CsrfMiddleware extends Middleware {
		public function handle($request){
			$body = $request->getBody();
			$csrf_token = $body["csrf_token"];
			if ($csrf_token !== Application::getSession("csrf_token")) throw new CsrfException("Csrf Exception");
		}
	}