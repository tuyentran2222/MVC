<?php
    namespace exceptions;

    abstract class GeneralException extends \Exception{
        public abstract function code();
        public abstract function message();
    }