<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\SearchProduct;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = product::all();
        return ProductResource::collection($data);
        //  return product::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields= $request->validate([

            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
            'category'=>'required |string'
        ]);
        if ($fields) {
            $product = Product::create([
                'quantity' => $fields['quantity'],
                'price' => $fields['price'],
                'date' => $fields['date'],
                'category' => $fields['category'],
            ]);

            // Product created successfully
            // ...

            return response()->json(['message' => 'Product created successfully'], Response::HTTP_CREATED);
        } else {
            // Validation failed
            return response()->json(['message' => 'Validation failed'], Response::HTTP_BAD_REQUEST);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
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


     /**
     * search for name
     *
     * @param  str $name
     * @return \Illuminate\Http\Response
     */
    public function search($category)
    {

        if (!$category) {
            return response([
                'message' => 'category that u looking for is not found!'], 403);
        }
       $data= product::where('category','like','%'.$category.'%')->get();
     return SearchProduct::collection($data);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return product::destroy($id);
    }
}
