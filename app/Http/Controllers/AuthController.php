<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        if(!$user || !Hash::check($request->input('password'), $user->password)){
            return response()->json([
                'message' => 'Invalid credentials!'
            ], 401);
        }

        // create access token and send back to user
        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'message' => 'Success',
            'token' => $token
        ]);
    }

    // logout user
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logged out'
        ], 200);
    }
}
