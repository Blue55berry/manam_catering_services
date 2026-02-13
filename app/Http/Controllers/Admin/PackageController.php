<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = \App\Models\Package::orderBy('price')->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\MenuCategory::active()->ordered()->with('activeMenuItems')->get();
        return view('admin.packages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|in:Veg,Non-Veg,Mixed',
            'features' => 'nullable|array',
            'features.*' => 'string|nullable',
            'menu_content' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        // Filter out empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features'], fn($value) => !is_null($value) && $value !== ''));
        }

        \App\Models\Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $package = \App\Models\Package::findOrFail($id);
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $package = \App\Models\Package::findOrFail($id);
        $categories = \App\Models\MenuCategory::active()->ordered()->with('activeMenuItems')->get();
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $package = \App\Models\Package::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|in:Veg,Non-Veg,Mixed',
            'features' => 'nullable|array',
            'features.*' => 'string|nullable',
            'menu_content' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        // Filter out empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features'], fn($value) => !is_null($value) && $value !== ''));
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $package = \App\Models\Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
