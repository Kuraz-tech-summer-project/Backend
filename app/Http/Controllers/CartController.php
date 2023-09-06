<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function createCart(Request $request)
    {
        $fields = $request->validate([
            'userId' => 'required',
            'productId' => 'required',
            'quantity' => 'required'
        ]);

        $user_exists = User::where('id', $fields['userId'])->exists();
        //Todo: Check if product also exists
        if ($user_exists) {
            $cartItem = Cart::create([
                'user_id' => $fields['userId'],
                'product_id' => $fields['productId'],
                'status' => 'Pending',
                'quantity' => $fields['quantity']
            ]);

            return $cartItem;
        }

        return response([
            'message' => 'User does not exist'
        ], 404);
    }

    public function findByUserId(Request $request, string $userId)
    {
        if (!$userId) {
            return response([
                'message' => 'User id was not provided!'
            ], 403);
        }

        $cartItems = Cart::where('user_id', $userId)->get();
        if (is_null($cartItems) || empty($cartItems)) {
            return response([
                'message' => 'cart is empty!'
            ], 200);
        }

        return $cartItems;
    }

    public function findByStatus(Request $request, string $userId, string $status) 
    {
        if (!$status || !$userId) {
            return response([
                'message' => 'status or userId was not provided!'
            ], 403);
        }

        $cartItems = Cart::where('status', $status)->where('user_id', $userId)->get();
        
        if (is_null($cartItems) || empty($cartItems)) {
            return response([
                'message' => 'cart with status '. $status . 'was not found!'
            ], 404);
        }

        return $cartItems;
    }

    public function deleteItem (Request $request, string $cartId)
    {
        if (!$cartId) {
            return response([
                'message' => 'cart item was not provided!'
            ], 403);
        }

        $cartItem = Cart::find($cartId);
        $cartItem->delete();
        $response = [
            'message' => 'Cart was successfully removed!!'
        ];

        return response($response, 200);
    }
}
