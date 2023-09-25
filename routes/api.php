<?php

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
  Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);

  //Reviews routes
  Route::get('/reviews', [ReviewController::class, 'getReviews']);
  Route::get('/reviews/id/{id}', [ReviewController::class, 'findById']);
  Route::get('/reviews/user_id/{userId}', [ReviewController::class, 'findByUserId']);
  Route::get('/reviews/product_id/{productId}', [ReviewController::class, 'findByProductId']);
  Route::post('/reviews', [ReviewController::class, 'createReview']);
  Route::put('/reviews/edit/{reviewId}', [ReviewController::class, 'editReview']);
  Route::delete('/reviews/{reviewId}', [ReviewController::class, 'deleteReview']);

  //Cart Routes
  Route::post('/carts', [CartController::class, 'createCart']);
  Route::get('/carts', [CartController::class, 'getCartItems']);
  Route::get('/carts/id/{cartId}', [CartController::class, 'findCartById']);
  Route::get('/carts/user/{userId}', [CartController::class, 'findByUserId']);
  Route::get('/carts/{userId}/{status}', [CartController::class, 'findByStatus']);
  Route::delete('/carts/id/{cartId}', [CartController::class, 'deleteItem']);

  //User routes
  Route::get('/users', [UserController::class, 'getUsers']);
  Route::get('/users/id/{id}', [UserController::class, 'findById']);
  Route::post('/users/signUp', [UserController::class, 'signUpUser']);
  Route::post('/users/signIn', [UserController::class, 'signInUser']);
  Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);

  //Reviews routes
  Route::get('/reviews', [ReviewController::class, 'getReviews']);
  Route::get('/reviews/id/{id}', [ReviewController::class, 'findById']);
  Route::get('/reviews/user_id/{userId}', [ReviewController::class, 'findByUserId']);
  Route::get('/reviews/product_id/{productId}', [ReviewController::class, 'findByProductId']);
  Route::post('/reviews', [ReviewController::class, 'createReview']);
  Route::put('/reviews/edit/{reviewId}', [ReviewController::class, 'editReview']);
  Route::delete('/reviews/{reviewId}', [ReviewController::class, 'deleteReview']);

  //Cart Routes
  Route::post('/carts', [CartController::class, 'createCart']);
  Route::get('/carts', [CartController::class, 'getCartItems']);
  Route::get('/carts/id/{cartId}', [CartController::class, 'findCartById']);
  Route::get('/carts/user/{userId}', [CartController::class, 'findByUserId']);
  Route::get('/carts/{userId}/{status}', [CartController::class, 'findByStatus']);
  Route::delete('/carts/id/{cartId}', [CartController::class, 'deleteItem']);

  // !yob-branch
  Route::get('/products', [ProductController::class, 'index']);
  Route::post('/products', [ProductController::class, 'store']);
  Route::get('/products/user/{userId}', [ProductController::class, 'findProductByUserId']);
  Route::get('/products/id/{id}', [ProductController::class, 'show']);
  Route::get('/products/search/{query}', [ProductController::class, 'search']);
  Route::delete('/products/delete/{id}', [ProductController::class, 'destroy']);

  //TODO image
  Route::post('/image/store', [ImageController::class, 'store']);
  Route::get('/image', [ImageController::class, 'index']);
  Route::get('/image/{id}', [ImageController::class, 'show']);
  Route::put('/image/edit/{id}', [ImageController::class, 'update']);
  Route::delete('/image/delete/{id}', [ImageController::class, 'destroy']);
});

//!protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::put('/products/edit/{id}', [ProductController::class, 'update']);
});
