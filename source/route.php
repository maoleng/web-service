<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Middlewares\AdminAuthenticate;
use App\Http\Middlewares\CustomerAuthenticate;
use Libraries\Redirect\Route;

/*
 * This file contains all the route of project
 * Request will find route to match the URL and Method
 * If it does not match any, it will return 404
 */

Route::get('/', [HomeController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::post('/product', [ProductController::class, 'store'])->middleware(AdminAuthenticate::class);
Route::put('/product/{id}', [ProductController::class, 'update'])->middleware(AdminAuthenticate::class);
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->middleware(AdminAuthenticate::class);

Route::get('/cart', [CartController::class, 'index'])->middleware(CustomerAuthenticate::class);
Route::put('/cart', [CartController::class, 'update'])->middleware(CustomerAuthenticate::class);

Route::post('/pay', [PaymentController::class, 'pay'])->middleware(CustomerAuthenticate::class);
Route::get('/pay/verify', [PaymentController::class, 'verifyPayment']);

Route::get('/order', [OrderController::class, 'index'])->middleware(CustomerAuthenticate::class);
Route::get('/order/{id}', [OrderController::class, 'show'])->middleware(CustomerAuthenticate::class);