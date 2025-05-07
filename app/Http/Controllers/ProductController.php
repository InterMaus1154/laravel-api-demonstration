<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function show(Product $product)
    {
        // throw 404 if product is hidden
        if($product->product_hidden){
            throw new NotFoundHttpException();
        }
        return response()->json(ProductResource::make($product));
    }

    public function store(Request $request)
    {

    }
}
