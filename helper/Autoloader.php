<?php

namespace helper;

class Autoloader {
    /**
     * @desc: autoload class
     */
    public static function register() {
        spl_autoload_register(function ($class) {
            $file = __DIR__ . "/../" . str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            if (!file_exists($file)) {
                return false;
            }
            require $file;
            return true;
        });
    }
}

