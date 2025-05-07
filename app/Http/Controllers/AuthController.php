<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // login user
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // try to find user
        $user = User::whereUsername($request->input('username'))->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials!'
            ], 401);
        }

        // create access token and send back to user
        $token = $user->tokens()->create([
            'token' => Str::random(64)
        ])->token;

        return response()->json([
            'message' => 'Success',
            'token' => $token
        ]);
    }

    // logout user
    public function logout(Request $request)
    {
        // revoke token
        UserToken::whereToken($request->bearerToken())->first()->update([
            'revoked_at' => now()
        ]);

        return response()->json([
            'message' => 'User logged out'
        ], 200);
    }

    // register user
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:75|unique:users,username',
            'email' => 'required|email|max:250|unique:users,email',
            'password' => 'required|string|min:4'
        ]);

        try {
            $user = User::create([
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            // login user
            $token = $user->tokens()->create([
                'token' => Str::random(64)
            ])->token;

            return response()->json([
                'message' => 'User successfully registered!',
                'data' => $user,
                'token' => $token
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Unknown error at creating user',
                'error' => $e->getMessage()
            ], 500);
        }


    }
}
