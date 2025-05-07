<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // show user info
    public function userInfo(Request $request)
    {
        $user = $request->user()->loadCount('products');
        return UserResource::make($user);
    }
}
