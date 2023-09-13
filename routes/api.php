<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProductController;
use App\Models\Images;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
                    //?public routes

Route::get('v1/products',[ProductController::class ,'index']);
Route::post('v1/products',[ProductController::class ,'store']);
Route::get('v1/products/{id}',[ProductController::class ,'show']);
Route::get('v1/products/search/{category}',[ProductController::class ,'search']);
Route::delete('/v1/products/delete/{id}',[ProductController::class ,'destroy']);


                        //TODO image
Route::post('v1/image/store',[ImagesController::class ,'store']);
Route::get('v1/image',[ImagesController::class ,'index']);
Route::get('v1/image/{id}',[ImagesController::class ,'show']);
Route::put('/v1/image/edit/{id}',[ImagesController::class ,'update']);
Route::delete('/v1/image/delete/{id}',[ImagesController::class ,'destroy']);

//Route::post('/products/{product}/images', [ImageController::class, 'store']);

                   //!protected routes

// Route::group(['middleware'=>['auth:sanctum']],function(){
//     Route::put('/v1/products/edit/{id}',[ProductController::class ,'update']);

// });
