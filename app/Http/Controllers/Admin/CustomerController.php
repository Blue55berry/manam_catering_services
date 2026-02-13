<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('city', 'LIKE', '%' . $search . '%');
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $categories = \App\Models\MenuCategory::with(['items' => function ($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->orderBy('order')->get();

        return view('admin.customers.create', compact('categories'));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'guest_count' => 'nullable|integer|min:1',
            'food_preferences' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['food_preferences'])) {
            // Filter out empty entries just in case
            $validated['food_preferences'] = array_filter($validated['food_preferences'], function ($pref) {
                return !empty($pref['name']);
            });
        }

        $validated['is_active'] = $request->has('is_active');

        Customer::create($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'guest_count' => 'nullable|integer|min:1',
            'food_preferences' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
