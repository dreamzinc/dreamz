<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/order-service/{id}', [HomeController::class, 'orderService'])->name('order-service');

Route::post('/order-course/{id}', [HomeController::class, 'orderCourse'])->name('order-course');
