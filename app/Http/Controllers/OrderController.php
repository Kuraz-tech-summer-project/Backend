<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function index(){
        return order::all();
    }
    public function storeorder(Request $request){
        $order = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
            'status' => 'required',
        ]);

        $order['users_id'] = Auth::id(); // Assign the authenticated user's ID

        $order = order::create($order);

        return response()->json($order, 201);
    }
}
