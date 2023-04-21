<?php


use App\Http\Controllers\AuthController;
use Libraries\Redirect\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

