<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
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

    // show all user products
    public function products(Request $request)
    {
        $user = $request->user()->loadMissing('products');
        return response()->json(ProductResource::collection($user->products));

    }
}
