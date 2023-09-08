<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::prefix('v1')->group(function () {
    //User routes
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/users/id/{id}', [UserController::class, 'findById']);
    Route::post('/users/signUp', [UserController::class, 'signUpUser']);
    Route::post('/users/signIn', [UserController::class, 'signInUser']);
    Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);

    //Reviews routes
    Route::get('/reviews/id/{id}', [ReviewController::class, 'findById']);
    Route::get('/reviews/user_id/{userId}', [ReviewController::class, 'findByUserId']);
    Route::get('/reviews/product_id/{productId}', [ReviewController::class, 'findByProductId']);
    Route::post('/reviews', [ReviewController::class, 'createReview']);
    Route::put('/reviews/edit/{reviewId}', [ReviewController::class, 'editReview']);
    Route::delete('/reviews/{reviewId}', [ReviewController::class, 'deleteReview']);

    //Cart Routes
    Route::post('/carts', [CartController::class, 'createCart']);
    Route::get('/carts/user/{userId}', [CartController::class, 'findByUserId']);
    Route::get('/carts/{userId}/{status}', [CartController::class, 'findByStatus']);
    Route::delete('/carts/id/{cartId}', [CartController::class, 'deleteItem']);
    Route::get('/reviews', [ReviewController::class, 'getReviews']);
});
