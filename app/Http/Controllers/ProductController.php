<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\SearchProduct;
use App\Http\Resources\ProductResource;
use App\Models\User;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        $query = Product::query();
        $sortBy = $request->input('sortby');
        $order = $request->input('order', 'asc');

        if ($sortBy) {
            $query->orderBy($sortBy, $order);
        }

        $products = $query->paginate();
        return new ProductCollection($products);
    }

    public function findProductByUserId(Request $request, string $userId)
    {
        if (!$userId) {
            return response([
                'message' => 'user id was not provided!'
            ], 403);
        }

        $products = Product::where('userId', $userId)->get();

        if (is_null($products) || empty($products)) {
            return response([
                'message' => 'product was not found!'
            ], 404);
        }

        return new ProductCollection($products);
    }


    public function store(Request $request)
    {

        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'userId' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
            'category' => 'required |string'
        ]);

        //only add product if user exists
        $user_exists = User::where('id', $fields['userId'])->exists();

        if ($user_exists) {
            $product = Product::create([
                'title' => $fields['title'],
                'description' => $fields['description'],
                'userId' => $fields['userId'],
                'quantity' => $fields['quantity'],
                'price' => $fields['price'],
                'date' => $fields['date'],
                'category' => $fields['category'],
            ]);

            return new ProductResource($product);
        }


        return response([
            'message' => 'Please Enter all the fields!!'
        ], 403);
    }


    public function show($id)
    {
        $product = product::find($id);
        if (is_null($product) || empty($product)) {
            return response([
                'message' => 'the product is not found!'
            ], 404);
        }

        return new ProductResource($product);
    }


    public function search($query)
    {

        if (!$query) {
            return response([
                'message' => 'the Product that you are looking for is not found!'
            ], 403);
        }

        $products = Product::where('title', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->orWhere('category', 'LIKE', "%$query%")
            ->paginate();

        return new ProductCollection($products);
    }


    public function update(Request $request, $id)
    {
        $product = product::find($id);
        $product->update($request->all());

        return new ProductResource($product);
    }

    public function destroy($id)
    {
        return new ProductResource(product::destroy($id));
    }
}
