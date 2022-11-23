<?php
    namespace core;
    
    class Server{
        /**
         * @desc get server value by key
         * @return string return server key value
         */
        public static function getServerByKey($key){
            return $_SERVER[$key] ?? "";
        }
    }