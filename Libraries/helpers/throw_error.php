<?php

if (! function_exists('customError')) {
    function customError($errno, $errstr, $errfile, $errline)
    {
        $message = $errstr;
        $file = $errfile;
        $line = $errline;
        $errors = [];
        require asset('Libraries/Response/views/debug.php');

        exit;
    }
}

if (! function_exists('throwHttpException')) {
    function throwHttpException($message)
    {
        response()->terminate($message);
    }
}
