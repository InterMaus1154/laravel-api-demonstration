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
        if ($product->product_hidden) {
            throw new NotFoundHttpException();
        }
        return response()->json(ProductResource::make($product->loadMissing('user')));
    }

    // create new product
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'product_name' => 'required|string|max:200',
            'product_price' => 'required|decimal:2',
            'product_stock' => 'required|numeric|min:0'
        ]);

        $product = $request->user()->products()->create([
           'category_id' => $request->input('category_id'),
           'product_name' => $request->input('product_name'),
           'product_price' => $request->input('product_price'),
           'product_stock' => $request->input('product_stock')
        ]);

        return response()->json([
            'message' => 'Product successfully created',
            'data' => ProductResource::make($product->refresh())
        ], 201);
    }

    // hide a product if owned by user
    public function markHidden(Request $request, Product $product)
    {
        if($product->user_id !== $request->user()->user_id){
            return response()->json([
                'message' => 'You are unauthorized to manage this product!'
            ], 403);
        }

        $product->update([
            'product_hidden' => true
        ]);
        return response()->json([
            'message' => 'Product successfully hidden',
            'data' => ProductResource::make($product)
        ], 200);
    }
}
