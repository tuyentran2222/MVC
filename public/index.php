<?php
	require "../helper/Autoloader.php";
	\helper\Autoloader::register();

	use controllers\AuthController;
	use controllers\UserController;
	use core\Application;
	use helper\Config;
	use helper\DotEnv;

	DotEnv::load(__DIR__ . "/../.env");
	$dbConfig = Config::getDBConfig();

	$app = new Application($dbConfig);

	$app->router->get("/login", "login", [middlewares\AuthMiddleware::class]);
	$app->router->post("/login", [AuthController::class, "login"], [middlewares\CsrfMiddleware::class]);
	$app->router->get("/register", "register");
	$app->router->post("/register", [AuthController::class, "register"], [middlewares\CsrfMiddleware::class]);
	$app->router->get("/verifyCode", "verifyCode", [middlewares\VerifyCodeMiddleware::class]);
	$app->router->post("/verifyCode", [AuthController::class, "verifyCode"], [middlewares\CsrfMiddleware::class]);
	$app->router->get("/forgetPassword", "forgetPassword");
	$app->router->post("/forgetPassword", [AuthController::class, "forgetPassword"]);
	$app->router->get("/changePassword", "changePassword", [middlewares\ChangePasswordMiddleware::class]);
	$app->router->post("/changePassword", [AuthController::class, "changePassword"], [middlewares\CsrfMiddleware::class]);
	$app->router->get("/logout", [AuthController::class, "logout"]);

	$app->router->get("/account", [UserController::class, "show"], [middlewares\AuthMiddleware::class]);
	$app->router->post("/updateUser", [UserController::class, "update"]);
	$app->router->post("/updateAvatar", [UserController::class, "updateAvatar"]);
	$app->run();

?>