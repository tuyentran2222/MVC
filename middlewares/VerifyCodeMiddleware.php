<?php
	namespace middlewares;

	use core\Application;
	use core\Middleware;

	class VerifyCodeMiddleware extends Middleware {
		public function handle($request){
			if (!Application::$app->getSession('email')) Application::redirect("/login");
		}
	}