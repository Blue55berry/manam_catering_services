<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_customer_can_place_order_with_event_details(): void
    {
        $category = MenuCategory::create(['name' => 'Test Category', 'is_active' => true, 'order' => 1]);
        $item = MenuItem::create([
            'category_id' => $category->id,
            'name' => 'Test Dish',
            'price' => 10.00,
            'is_active' => true,
            'order' => 1
        ]);

        $cart = [
            $item->id => [
                'name' => 'Test Dish',
                'quantity' => 2,
                'price' => 10.00,
                'image' => null
            ]
        ];
        session(['cart' => $cart]);

        $orderData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address_1' => '123 Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'event_type' => 'Wedding',
            'event_date' => '2026-05-20',
            'food_requirements' => 'Allergic to nuts',
        ];

        // $this->withoutExceptionHandling();
        // $response = $this->post(route('checkout.store'), $orderData);

        $request = Request::create(route('checkout.store'), 'POST', $orderData);
        $request->setLaravelSession(session());
        
        $controller = new \App\Http\Controllers\CheckoutController();
        try {
            $response = $controller->store($request);
        } catch (\Exception $e) {
            dd('Caught exception: ' . $e->getMessage(), $e->getTraceAsString());
        }

        if ($response instanceof \Illuminate\Http\RedirectResponse) {
             $this->assertEquals(route('home'), $response->getTargetUrl());
        }
        
        $order = Order::where('email', 'john@example.com')->first();
        if (!$order) {
            $orders = Order::all();
            dd('Order not found. All orders:', $orders->toArray());
        }

        $this->assertEquals('Wedding', $order->event_type);
        $this->assertEquals(20.00, $order->total);

        $order = Order::where('email', 'john@example.com')->first();
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'menu_item_id' => $item->id,
            'quantity' => 2,
            'price' => 10.00
        ]);
    }
}
