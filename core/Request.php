<?php
    namespace core;

    class Request{
        /**
         * @desc get path of request
         * @return string return path of request
         */
        public function getPath(){
            $path = $_SERVER['REQUEST_URI']?? "/";
            $position = strpos($path, '?');
            if ($position === false) return $path;
            return substr($path, 0, $position);
        }

        /**
         * @desc get method of request
         * @return string return method of request
         */
        public function getMethod(){
            return strtolower($_SERVER['REQUEST_METHOD']);
        }

        /**
         * @desc get data, which was sent with request
         * @return array return data
         */
        public function getBody(){
            $body = [];

            if ($this->getMethod() === 'get'){
                foreach($_GET as $key => $value){
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            if ($this->getMethod() === 'post'){
                foreach($_POST as $key => $value){
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
            return $body;
        }

        /**
         * @desc get data by attribute, which was sent with request
         * @param string $attribute param which expect receive data.
         * @return mixed return data
         */
        public function getBodyByKey($attribute){
            $body = $this->getBody();
            return $body[$attribute] ?? "";
        }

        /**
         * @desc check method is post
         * @return boolean return true if method is post otherwise return false
         */
        public function isPost(){
            return $this->getMethod() === 'post';
        }

        /**
         * @desc check method is get
         * @return boolean return true if method is get otherwise return false
         */
        public function isGet(){
            return $this->getMethod() === 'get';
        }

         /**
         * @desc check has file when sending request by file name
         * @param string $fileName
         * @return boolean return true if has file otherwise return false
         */
        public function hasFile($fileName){
            return $_FILES[$fileName] ?? false;
        }
    }