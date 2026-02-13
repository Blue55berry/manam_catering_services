<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Calculate totals
        $subtotal = 0;
        foreach($cart as $item) {
            $price = floatval(preg_replace('/[^\d.]/', '', $item['price']));
            $subtotal += $price * $item['quantity'];
        }
        $total = $subtotal; // Add tax calculation logic here if needed

        return view('checkout.index', compact('cart', 'subtotal', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'event_type' => 'required',
            'event_date' => 'required|date',
            'food_requirements' => 'nullable',
        ]);

        try {
            $cart = session()->get('cart', []);
            $total = 0;
            foreach ($cart as $id => $details) {
                // Ensure price is numeric
                $price = floatval(preg_replace('/[^\d.]/', '', $details['price']));
                $total += $price * $details['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'event_type' => $request->event_type,
                'event_date' => $request->event_date,
                'food_requirements' => $request->food_requirements,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart as $id => $details) {
                $price = floatval(preg_replace('/[^\d.]/', '', $details['price']));
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                ]);
            }

            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error processing your order. Please try again.');
        }
    }
}
