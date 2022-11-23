<?php

    namespace core;

    use core\Database;

    class Application{
        public static $app;
        public const ROOT_DIR = __DIR__."/../" ;
        public $router;
        public $request;
        public $response;
        public $database;
        public $session;
        public $cookie;

        public function __construct($dbConfig){
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router($this->request, $this->response);
            $this->database = new Database($dbConfig['host'], $dbConfig['dbname'], $dbConfig['username'], $dbConfig['password']);
            $this->session = new Session();
            $this->cookie = new Cookie();
            self::$app =  $this;
        }

        public function run(){
            $this->router->resolve();
        }

        public static function setSession($key, $value){
            static::$app->session->setSession($key, $value);
        }

        public static function setFlashSession($key, $value){
            static::$app->session->setFlashSession($key, $value);
        }

        public static function getSession($key){
            return static::$app->session->getSession($key);
        }

        public static function renderView($view, $params = [], $layout){
            return static::$app->router->renderView($view, $params, $layout);
        }

        /**
         * @param string $url
         * @return void
         */
        public static function redirect($url){
            static::$app->response->redirect($url);
        }
    }