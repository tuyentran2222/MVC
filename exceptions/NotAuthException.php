<?php
    namespace exceptions;

    class NotAuthException extends GeneralException{
        public function code(){
            return 401;
        }
        public function message(){
            return "Unauthorized";
        }
    }