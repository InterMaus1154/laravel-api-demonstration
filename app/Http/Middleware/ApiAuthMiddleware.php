<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()
            || !UserToken::whereToken($request->bearerToken())->exists()
            || !UserToken::whereToken($request->bearerToken())->whereRevokedAt(null)->exists()) {
            return response()->json([
                'message' => 'Missing or invalid token'
            ], 401);
        }

        // make user available on request->user()
        $request->setUserResolver(function () use ($request) {
            return UserToken::whereToken($request->bearerToken())->first()->user;
        });

        return $next($request);
    }
}
