<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImagesResource;

class ImageController extends Controller
{
   public function index(){
   $data =images::all();
   return ImagesResource::collection($data);
   }
   public function store(ImageRequest $request){

    $userId = $request->input('users_id');
    $productId = $request->input('product_id');

    $user = User::find($userId);
    $product = product::find($productId);
    if($user&&$product){
    $record = images::create([
        'users_id' => $userId,
        'product_id' => $productId,
        'images_url' => $request->images_url,
    ]);
    return response()->json($record, 201);
     }
     return response()->json(['message' => ' User or Product id  Not Found',404]);

    }
     public function update(ImageRequest $request,$id){

        $image = images::find($id);
        if($image){
             $image->images_url = $request->images_url;


    $image->save();

    // Return a response
    return response()->json(['message' => 'Resource updated successfully']);
     }
     return response()->json(['message' => 'Resource NOT FOUND',404]);
    }
     public function destroy($id){
        $image=images::find($id);
        if($image){
            $image->delete();
            return response()->json(['message' => 'Resource deleted successfully']);
        }
        return response()->json(['message' => 'Image Not Found',404]);
     }
}
