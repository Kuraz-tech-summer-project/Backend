<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
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
Route::prefix('v1')->group(function () {
  //User routes
  Route::get('/users', [UserController::class, 'getUsers']);
  Route::get('/users/id/{id}', [UserController::class, 'findById']);
  Route::post('/users/signUp', [UserController::class, 'signUpUser']);
  Route::post('/users/signIn', [UserController::class, 'signInUser']);
  Route::post('/admins/signUp', [AdminController::class, 'signUpUser']);
  Route::post('/admins/signIn', [AdminController::class, 'signInUser']);

  //Reviews routes
  Route::get('/reviews', [ReviewController::class, 'getReviews']);
  Route::get('/reviews/id/{id}', [ReviewController::class, 'findById']);
  Route::get('/reviews/user_id/{userId}', [ReviewController::class, 'findByUserId']);
  Route::get('/reviews/product_id/{productId}', [ReviewController::class, 'findByProductId']);

  //Cart routes
  Route::get('/carts', [CartController::class, 'getCartItems']);
  Route::get('/carts/id/{cartId}', [CartController::class, 'findCartById']);
  Route::get('/carts/user/{userId}', [CartController::class, 'findByUserId']);
  Route::get('/carts/{userId}/{status}', [CartController::class, 'findByStatus']);

  //Product route
  Route::get('/products', [ProductController::class, 'index']);
  Route::get('/products/user/{userId}', [ProductController::class, 'findProductByUserId']);
  Route::get('/products/id/{id}', [ProductController::class, 'show']);
  Route::get('/products/search/{query}', [ProductController::class, 'search']);

  //Image route
  Route::get('/image', [ImageController::class, 'index']);
  Route::get('/image/{id}', [ImageController::class, 'show']);


  Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
  });

  // Routes accessible only to users
  Route::group(['middleware' => ['auth:sanctum', 'role:user']], function () {
    Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);
    Route::post('/reviews', [ReviewController::class, 'createReview']);
    Route::put('/reviews/edit/{reviewId}', [ReviewController::class, 'editReview']);
    Route::delete('/reviews/{reviewId}', [ReviewController::class, 'deleteReview']);
    Route::post('/carts', [CartController::class, 'createCart']);
    Route::delete('/carts/id/{cartId}', [CartController::class, 'deleteItem']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy']);
    Route::post('/image/store', [ImageController::class, 'store']);
    Route::put('/image/edit/{id}', [ImageController::class, 'update']);
    Route::delete('/image/delete/{id}', [ImageController::class, 'destroy']);
    Route::put('/products/edit/{id}', [ProductController::class, 'update']);
  });
});
