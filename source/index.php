<?php

foreach (scandir(__DIR__.'/Libraries/helpers') as $filename) {
    $path = __DIR__.'/Libraries/helpers/' . $filename;
    if (is_file($path)) {
        require $path;
    }
}

// Load classes
require_once('Libraries/AppLoader.php');
Libraries\AppLoader::load();

// Action the request
(new Libraries\Request\Request())->action();