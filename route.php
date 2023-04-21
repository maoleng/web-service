<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Middlewares\AdminAuthenticate;
use App\Http\Middlewares\CustomerAuthenticate;
use Libraries\Redirect\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::post('/product', [ProductController::class, 'store'])->middleware(AdminAuthenticate::class);
Route::put('/product/{id}', [ProductController::class, 'update'])->middleware(AdminAuthenticate::class);
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->middleware(AdminAuthenticate::class);

Route::get('/cart', [CartController::class, 'index'])->middleware(CustomerAuthenticate::class);
