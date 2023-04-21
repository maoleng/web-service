<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookTicketController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Middlewares\AdminAuthenticate;
use App\Http\Middlewares\IfAlreadyLogin;
use App\Http\Middlewares\MustLogin;
use Libraries\Redirect\Route;

####### Customer Route #######
Route::get('/', [HomeController::class, 'index']);
Route::get('/{name}', [HomeController::class, 'show']);
Route::get('/now_showing_movie', [HomeController::class, 'nowShowing']);
Route::get('/coming_soon_movie', [HomeController::class, 'comingSoon']);

Route::get('/login', [AuthController::class, 'login'])->middleware(IfAlreadyLogin::class);
Route::get('/register', [AuthController::class, 'register'])->middleware(IfAlreadyLogin::class);
Route::post('/process_login', [AuthController::class, 'processLogin'])->middleware(IfAlreadyLogin::class);
Route::post('/process_register', [AuthController::class, 'processRegister'])->middleware(IfAlreadyLogin::class);
Route::get('/logout', [AuthController::class, 'logout'])->middleware(MustLogin::class);

Route::get('/profile', [ProfileController::class, 'index'])->middleware(MustLogin::class);
Route::post('/profile', [ProfileController::class, 'update'])->middleware(MustLogin::class);

Route::post('/order/choose_schedule', [BookTicketController::class, 'chooseSchedule'])->middleware(MustLogin::class);
Route::get('/order/choose_seat', [BookTicketController::class, 'chooseSeat'])->middleware(MustLogin::class);
Route::get('/order/choose_seat/{id}', [BookTicketController::class, 'processChooseSeat'])->middleware(MustLogin::class);
Route::get('/order/choose_combo', [BookTicketController::class, 'chooseCombo'])->middleware(MustLogin::class);
Route::post('/order/choose_combo', [BookTicketController::class, 'processChooseCombo'])->middleware(MustLogin::class);
Route::post('/order/pay', [BookTicketController::class, 'pay'])->middleware(MustLogin::class);
Route::post('/order/pay/callback', [BookTicketController::class, 'callback'])->middleware(MustLogin::class);
Route::get('/order/history', [BookTicketController::class, 'history'])->middleware(MustLogin::class);

####### Admin route #######
Route::get('/admin', [DashboardController::class, 'index'])->middleware(AdminAuthenticate::class);

Route::get('/admin/order', [OrderController::class, 'index'])->middleware(AdminAuthenticate::class);
Route::get('/admin/order/{id}', [OrderController::class, 'show'])->middleware(MustLogin::class);

Route::get('/admin/schedule', [ScheduleController::class, 'index'])->middleware(AdminAuthenticate::class);
Route::post('/admin/schedule', [ScheduleController::class, 'store'])->middleware(AdminAuthenticate::class);
Route::post('/admin/schedule/{id}', [ScheduleController::class, 'update'])->middleware(AdminAuthenticate::class);
Route::post('/admin/schedule/destroy/{id}', [ScheduleController::class, 'destroy'])->middleware(AdminAuthenticate::class);

Route::get('/admin/movie', [MovieController::class, 'index'])->middleware(AdminAuthenticate::class);
Route::get('/admin/movie/{id}', [MovieController::class, 'show'])->middleware(AdminAuthenticate::class);
Route::get('/admin/movie/create', [MovieController::class, 'create'])->middleware(AdminAuthenticate::class);
Route::post('/admin/movie/store', [MovieController::class, 'store'])->middleware(AdminAuthenticate::class);
Route::get('/admin/movie/edit/{id}', [MovieController::class, 'edit'])->middleware(AdminAuthenticate::class);
Route::post('/admin/movie/update/{id}', [MovieController::class, 'update'])->middleware(AdminAuthenticate::class);
Route::post('/admin/movie/destroy/{id}', [MovieController::class, 'destroy'])->middleware(AdminAuthenticate::class);

Route::get('/admin/customer', [CustomerController::class, 'index'])->middleware(AdminAuthenticate::class);
