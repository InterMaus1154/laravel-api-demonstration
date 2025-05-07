<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


// all routes prefixed with v1
Route::prefix('v1')->group(function () {

    // test route to test if API is running
    Route::get('/test', function () {
        return response('API is running', 200);
    });

    // login user
    Route::post('/login', [AuthController::class, 'login']);

    // register user
    Route::post('/register', [AuthController::class, 'register']);

    // routes require authenticated user (bearer token)
    Route::middleware('auth:sanctum')->group(function () {

        // logout
        Route::post('/logout', [AuthController::class, 'logout']);

        // show logged-in user info
        Route::get('/users/me', [UserController::class, 'userInfo']);

        // show logged-in user products (all)
        Route::get('/users/me/products', [UserController::class, 'products']);

    });

    // get all non-hidden products
    Route::get('/products', [ProductController::class, 'index']);

    // get non-hidden products for a user
    Route::get('/user/{user}/products', [ProductController::class, 'userProducts']);

});

