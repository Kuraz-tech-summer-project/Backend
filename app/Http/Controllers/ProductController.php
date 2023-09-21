<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SearchProduct;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{

    public function index()
    {

        $data = product::all();
        return ProductResource::collection($data);

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $userId = $request->input('users_id');
        //  User::find($userId);

        //  $userId = auth()->user()->id;

        $fields= $request->validate([
            // 'users_id' => 'exists:users,id',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
            'category'=>'required |string'
        ]);
        if ($fields) {
            $product = Product::create([
                // 'users_id' => $userId,
                'quantity' => $fields['quantity'],
                'price' => $fields['price'],
                'date' => $fields['date'],
                'category' => $fields['category'],
            ]);


            return response()->json(['message' => 'Product created successfully'], Response::HTTP_CREATED);
        } else {

            return response()->json(['message' => 'Validation failed'], Response::HTTP_BAD_REQUEST);
        }


    }


    public function show($id)
    {
        $product= product::find($id);
        if (is_null($product) || empty($product)) {
            return response([
                'message' => 'the product is not found!'
            ], 404);
        }

        return response($product, 200);
    }



    public function search($category)
    {

        if (!$category) {
            return response([
                'message' => 'category that u looking for is not found!'], 403);
        }
       $data= product::where('category','like','%'.$category.'%')->get();
     return SearchProduct::collection($data);
    }




    public function update(Request $request, $id)
    {
        $product=product::find($id);
        // $product=$request->validate([
        //     'quantity' => 'integer',
        //     'price' => 'numeric',
        //     'date' => 'date',
        //     'category' => 'string',
        // ]);

        $product->update($request->all());

        return $product;
    }


    public function destroy($id)
    {
        return product::destroy($id);
    }
}
