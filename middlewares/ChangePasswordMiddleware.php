<?php
	namespace middlewares;

	use core\Application;
	use core\Middleware;

	class ChangePasswordMiddleware extends Middleware {
		public function handle($request){
			if (!Application::$app->getSession("changePassword") || !Application::$app->getSession("email")) Application::$app->redirect("/login");
		}
	}