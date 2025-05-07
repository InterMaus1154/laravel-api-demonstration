<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // return all non-hidden products
    public function index()
    {
        $products = Product::whereProductHidden(false)->with('category', 'user')->get();

        return response()->json(ProductResource::collection($products));
    }

    public function userProducts(User $user)
    {
        $products = $user->products()->whereProductHidden(false)->with('category')->get();
        return response()->json(ProductResource::collection($products));
    }
}
