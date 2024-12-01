<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        if (auth()->check()) {

            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active']
            );

            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {

                $cartItem->quantity += $quantity;
                $cartItem->total_price = $cartItem->quantity * $cartItem->price;
                $cartItem->save();
            } else {

                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total_price' => $product->price * $quantity,
                ]);
            }
        } else {

            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
                $cart[$productId]['total_price'] = $cart[$productId]['quantity'] * $cart[$productId]['price'];
            } else {
                $cart[$productId] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total_price' => $product->price * $quantity,
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'message' => 'Product added to cart!',
            'cartItemCount' => $this->getCartItemCount()
        ]);
    }


    public function getCartItems(Request $request)
    {

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'active'],
            ['status' => 'active']
        );

        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with(['product', 'product.category'])
            ->get();

        return response()->json([
            'cartItems' => $cartItems
        ]);
    }


    public function removeFromCart($productId)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->first();
    
        if (!$cart) {
            return response()->json(['message' => 'Cart not found for the user'], 404);
        }
    
        Log::info('Removing product from cart', ['cart_id' => $cart->id, 'product_id' => $productId]);
    
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();
    
        if ($cartItem) {
            $cartItem->delete();
    
            return response()->json(['message' => 'Product removed from cart']);
        }
    
        // If the product is not found in the cart, return an error
        return response()->json(['message' => 'Product not found in cart'], 404);
    }
    

    public function getCartItemCount()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            return response()->json(['count' => $cart ? $cart->items->sum('quantity') : 0]);
        } else {
            $cart = session()->get('cart', []);
            return response()->json(['count' => array_sum(array_column($cart, 'quantity'))]);
        }
    }


    public function myCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'status' => 'active'],
            ['status' => 'active']
        );

        $cartItems = CartItem::where('cart_id', $cart->id)
            ->with(['product', 'product.category'])
            ->get();

        return response()->json([
            'cartItems' => $cartItems
        ]);
    }



    public function mergeCart()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'User must be logged in to merge cart.'], 401);
        }

        $sessionCart = session()->get('cart', []);

        if (!empty($sessionCart)) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active']
            );

            foreach ($sessionCart as $productId => $item) {
                $cart->items()->updateOrCreate(
                    ['product_id' => $productId],
                    [
                        'quantity' => DB::raw("quantity + {$item['quantity']}"),
                        'price' => $item['price'],
                        'total_price' => $item['total_price']
                    ]
                );
            }

            session()->forget('cart');
        }

        return response()->json(['message' => 'Cart merged successfully.']);
    }
}
