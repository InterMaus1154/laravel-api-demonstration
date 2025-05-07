<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\ForceJsonApiMiddleware;
use App\Http\Controllers\ProductController;


// all routes prefixed with v1
Route::prefix('v1')->group(function(){

    // test route to test if API is running
    Route::get('/test', function(){
        return response('API is running', 200);
    });

    // login user
    Route::post('/login', [AuthController::class, 'login']);

    // register user
    Route::post('/register', [AuthController::class, 'register']);

    // routes require authenticated user (bearer token)
    Route::middleware('auth:sanctum')->group(function(){

        // logout
        Route::post('/logout', [AuthController::class, 'logout']);

    });

    // get all non-hidden products
    Route::get('/products', [ProductController::class, 'index']);

});

