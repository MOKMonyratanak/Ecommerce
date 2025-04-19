<?php

use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\User\ProductController;
use App\Http\Controllers\Api\v1\User\ExportController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('products/{id}', [ProductController::class, 'getProduct']);
Route::get('products', [ProductController::class, 'getAllProducts']);

Route::group(['middleware' => 'auth:api-user', 'prefix' => 'auth/v1'], function ($router) {
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('exports', [ExportController::class, 'createExport']);
    Route::get('exports/{global_id}', [ExportController::class, 'getExport']);
    Route::get('exports', [ExportController::class, 'getAllExports']);
});