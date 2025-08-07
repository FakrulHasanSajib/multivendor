<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\VendorController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Routes that do not require authentication.
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
|
| These routes are protected by Sanctum middleware and require a valid API token.
|
*/
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Resource routes are now protected
    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);

    // Search route also protected
    Route::get('/products/search/{key}', [ProductController::class, 'search']);
});