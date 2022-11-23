<?php
	namespace core;

	use exceptions\GeneralException;

	class Router{
		private $request;
		private $response;
		private $routes = [];
		private $middlewares = [];

		public function __construct($request, $response){
			$this->request = $request;
			$this->response = $response;
		}

		/**
		 * @desc add route has method is get into routes list array
		 * @param string $path path of route
		 * @param array $callback callback, which is called when run route
		 * @param array $middlewares
		 * @return void
		 */
		public function get($path, $callback, $middlewares=[]){
			$this->middlewares["get"][$path] = $middlewares;
			$this->routes["get"][$path] =  $callback;
		}

		/**
		 * @desc add route has method is post into routes list array
		 * @param string $path path of route
		 * @param array $callback callback, which is called when run route
		 * @param array $middlewares
		 * @return void
		 */
		public function post($path, $callback, $middlewares=[]){
			$this->middlewares["post"][$path] = $middlewares;
			$this->routes["post"][$path] =  $callback;
		}

		/**
		 * @desc determine path, method and render view
		 * @return void
		 */
		public function resolve(){
			$path = $this->request->getPath();
			$method = $this->request->getMethod();
		
			$callback = $this->routes[$method][$path] ?? [];
			$middleware_array = $this->middlewares[$method][$path] ?? [];
			if (!$callback){
				$this->response->setStatusCode(404);
				return $this->renderView("404", [], "main");
			}

			try{
				if ($middleware_array){
					foreach ($middleware_array as $middleware){
						(new $middleware())->handle($this->request);
					}
				}

				if (is_string($callback)){
					return $this->renderView($callback);
				}
				$callback[0] =  new $callback[0]();
				if (is_array($callback)){
					return call_user_func($callback, $this->request);
				}
				return call_user_func($callback, $this->request);
			}
			catch (GeneralException $e) {
				$this->response->setStatusCode($e->code());
				$this->renderView("error", [
					"message" => $e->message()
				]);
			} catch(\Exception $e){
				$this->response->setStatusCode(500);
				$this->renderView("error", [
					"message" => "Internal server error"
				]);
			}

		}

		/**
		 * @desc render view contain view content and view layout
		 * @param string $view view content
		 * @param array $params data what is passed to view
		 * @param string $layout layout view
		 * @param array $css_files css files import to html file
		 * @return void
		 */
		public function renderView($view, $params = [], $layout="main"){
			$layoutContent = $this->layoutContent($layout, $view, $params);
			$viewContent = $this->renderOnlyView($view, $params);
			$view = str_replace("{{content}}", $viewContent, $layoutContent);
			echo $view;
		}

		/**
		 * @desc get layout content
		 * @param array $params data what is passed to view
		 * @param string $layout layout view
		 * @param array $css_files css files import to html file
		 * @return string|false
		 */
		private function layoutContent($layout, $view, $params=[]){
			$view =  $view;
			foreach ($params as $key => $value){
				$$key = $value;
			}
			$notify = \core\Application::$app->session->getFlashSession('notify');
			ob_start();
			include_once Application::ROOT_DIR."/views/layout/$layout.php";
			return ob_get_clean();
		}

		private function renderOnlyView($view, $params=[]){
			foreach ($params as $key => $value){
				$$key = $value;
			}
			$csrf_token = Application::getSession("csrf_token");
			$failed_attempt_login = Application::getSession("failed_attempt_login");
			ob_start();
			include_once Application::ROOT_DIR."/views/$view.php";
			return ob_get_clean();
		}
	}