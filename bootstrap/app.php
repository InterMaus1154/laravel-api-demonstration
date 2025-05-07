<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(\App\Http\Middleware\ForceJsonApiMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function(\Illuminate\Auth\AuthenticationException $e, Request $request){
            // unauthenticated message on api routes
            if($request->is('api/*')){
                return response()->json([
                   'message' => 'Token is invalid',
                ], 401);
            }
        });
    })->create();
