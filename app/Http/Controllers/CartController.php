<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $price = floatval(preg_replace('/[^\d.]/', '', $request->price));
            $cart[$id] = [
                "name" => $request->name,
                "quantity" => 1,
                "price" => $price,
                "image" => $request->image
            ];
        }

        session()->put('cart', $cart);
        
        $totalQuantity = 0;
        foreach($cart as $item) {
            $totalQuantity += $item['quantity'];
        }

        return response()->json(['success' => 'Product added to cart successfully!', 'total_quantity' => $totalQuantity]);
    }

    public function getCartCount() 
    {
        $cart = session()->get('cart', []);
        $totalQuantity = 0;
        foreach($cart as $item) {
            $totalQuantity += $item['quantity'];
        }
        return response()->json(['count' => $totalQuantity]);
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            
            $subtotal = 0;
            $count = 0;
            foreach($cart as $item) {
                // Sanitize price in case it's a string from old session data
                $price = floatval(preg_replace('/[^\d.]/', '', $item['price']));
                $subtotal += $price * $item['quantity'];
                $count += $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal * 1.05, 2), // Assuming 5% tax as per view
                'count' => $count
            ]);
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            
            $subtotal = 0;
            $count = 0;
            foreach($cart as $item) {
                // Sanitize price in case it's a string from old session data
                $price = floatval(preg_replace('/[^\d.]/', '', $item['price']));
                $subtotal += $price * $item['quantity'];
                $count += $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal * 1.05, 2),
                'count' => $count
            ]);
        }
    }
}
