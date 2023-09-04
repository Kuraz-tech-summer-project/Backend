<?php

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
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/users/id/{id}', [UserController::class, 'findById']);
    Route::post('/users/signUp', [UserController::class, 'signUpUser']);
    Route::post('/users/signIn', [UserController::class, 'signInUser']);
    Route::put('/users/edit/{id}', [UserController::class, 'updateUser']);
});
