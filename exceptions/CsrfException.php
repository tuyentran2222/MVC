<?php
    namespace exceptions;

    class CsrfException extends GeneralException{
        public function code(){
            return 406;
        }
        public function message(){
            return "CSRF Exception";
        }
    }