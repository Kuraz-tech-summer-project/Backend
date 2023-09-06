<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return product::all();
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
            'date' => 'required|date',
            'category'=>'required |string'
        ]);
        $product= product::create([
            'quantity'=>$fields['quantity'],
            'price'=>$fields['price'],
            'date'=>$fields['date'],
            'category'=>$fields['category'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return product::find($id);
    }

     /**
     * search for name
     *
     * @param  str $name
     * @return \Illuminate\Http\Response
     */
    public function search($category)
    {
        return product::where('category','like','%'.$category.'%')->get();
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
