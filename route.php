<?php


use Libraries\Redirect\Route;

Route::delete('/', function () {
    abort(400);
    response()->message('a');
    echo 1;
});