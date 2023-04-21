<?php

foreach (scandir(__DIR__.'/Libraries/helpers') as $filename) {
    $path = __DIR__.'/Libraries/helpers/' . $filename;
    if (is_file($path)) {
        require $path;
    }
}

if (env('APP_ENV') === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    set_error_handler('customError');
}

// Load classes
require_once('Libraries/AppLoader.php');
Libraries\AppLoader::load();

// Action the request
(new Libraries\Request\Request())->action();