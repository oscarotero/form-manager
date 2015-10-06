<?php

spl_autoload_register(function ($class) {
    if (strpos($class, 'FormManager\\') !== 0) {
        return;
    }

    $file = __DIR__.str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen('FormManager'))).'.php';

    if (is_file($file)) {
        require_once $file;
    }
});
