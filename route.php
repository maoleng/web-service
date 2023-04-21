<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Libraries\Redirect\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);