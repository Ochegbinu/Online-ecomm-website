<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function apiIndex()
    {
        $orders = Cart::with(['items.product'])
            ->where('user_id', auth()->id())
            ->get()
            ->map(function ($cart) {
                return [
                    'id' => $cart->id,
                    'user_id' => $cart->user_id,
                    'status' => $cart->status,
                    'created_at' => $cart->created_at,
                    'updated_at' => $cart->updated_at,
                    'total' => $cart->items->sum('total_price'),
                    'items' => $cart->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'cart_id' => $item->cart_id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total_price' => $item->total_price,
                            'product' => $item->product
                        ];
                    })
                ];
            });
    
        return response()->json($orders);
    }
}
