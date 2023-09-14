<?php

namespace App\Http\Controllers;
use App\Http\requests\ImageStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $image = images::all();

        // Return Json Response
        return response()->json([
           'image' => $image
        ],200);
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
    public function store(ImageStoreRequest $request)
    {
        try{
        $imageName = $request->image->getClientOriginalName();

        images::create([

            'image' => $imageName,
        ]);

        // Save Image in Storage folder
        Storage::disk('public')->putFileAs('', $request->image, $imageName);

        // Return JSON Response
        return response()->json([
            'message' => 'image successfully created.'
        ], 200);

    } catch (\Exception $e) {
        // Return JSON Response
        return response()->json([
            'message' => 'Something went really wrong!'
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = images::find($id);
           if($image){
            return response()->json($image);
           }
           return response([
            'massage'=>'Image is not found'], 200);


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageStoreRequest $request, $id)
    {
        try {
            // Find image
            $image = images::find($id);
            if(!$image){
              return response()->json([
                'message'=>'Image Not Found.'
              ],404);
            }
            if($request->images) {
                // Public storage
                $storage = Storage::disk('public');

                // Old iamge delete
                if($storage->exists($image->images))
                    $storage->delete($image->images);
                 // Image name
                 $imageName = $request->images->getClientOriginalName();
                 $image->images = $imageName;

                 // Image save in public folder
                 $storage->put($imageName, file_get_contents($request->images));
             }
             $image->save();

             // Return Json Response
             return response()->json([
                 'message' => "Image successfully updated."
             ],200);
         } catch (\Exception $e) {
             // Return Json Response
             return response([
                 'message' => "Something went really wrong!"
             ],500);
         }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $images=images::find($id);
        if($images){
            Storage::delete('public/images/' . $images);
            $images->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Image deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image not found'
            ]);
        }



    }


}
