<?php

use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProductController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('products/{id}', [ProductController::class, 'getProduct']);
Route::get('products', [ProductController::class, 'getAllProducts']);