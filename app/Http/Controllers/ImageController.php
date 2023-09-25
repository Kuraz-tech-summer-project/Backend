<?php

namespace App\Http\Controllers;
use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    //
   public function index(){
    return images::all();
   }
   public function store(Request $request){
    $feild = $request->validate([
        'product_id' => 'required|integer',
        'images_url' => 'required|url',
        'status' => 'in:pending,Delivered',
    ]);
    //$imageUrl = $request->input('images_url');
   // $userId = $request->input('users_id');
    $productId = $request->input('product_id');
    $feild['users_id'] = Auth::id();
     Images::create([
        //'user_id' => $userId,
        'product_id' => $productId,
        'images_url' => $feild['images_url'],
        'status' => $feild['status'],
    ]);



    return response(['message' => 'images url stored',202]);
    // $user = Auth::user();
    // $product = Product::find($request->input('product_id'));

    // $image = new Images;
    // $image->user_id = $user->id;
    // $image->product_id = $product->id;
    // // set other image properties...
    // $image->save();

    // return response()->json($image, 201);
   }
}
