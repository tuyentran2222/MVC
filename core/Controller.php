<?php
	namespace core;

	class Controller {
		/**
		 * @desc get default layout
		 * @return string layout
		 */
		public function layout(){
			return "main";
		}

		/**
		 * @desc: render view
		 * @param string $view
		 * @param array $params data what is passed to view
		 * @param string $layout layout view
		 * @param array $css_files css files import to html file
		 * @return void
		 */
		public function render($view, $params=[], $layout="") {
			if (!$layout){
				$layout = $this->layout();
			}
			return Application::$app->router->renderView($view, $params, $layout);
		}
	}