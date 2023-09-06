<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('v1/products',[ProductController::class ,'index']);
Route::post('v1/products',[ProductController::class ,'store']);
Route::get('v1/products/{id}',[ProductController::class ,'show']);
Route::get('v1/products/search/{category}',[ProductController::class ,'search']);
Route::put('/v1/products/edit/{id}',[ProductController::class ,'update']);
Route::delete('/v1/products/delete/{id}',[ProductController::class ,'destroy']);

 //!protected routes

Route::group(['middleware'=>['auth:sanctum']],function(){

});
