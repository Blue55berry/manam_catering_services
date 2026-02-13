<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuCategoryController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::orderBy('order')->get();
        return view('admin.menu-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.menu-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:menu_categories,name',
        ]);

        MenuCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => true,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->to(route('admin.menu-items.index') . '#categories')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $menu_category = MenuCategory::findOrFail($id);
        return view('admin.menu-categories.edit', compact('menu_category'));
    }

    public function update(Request $request, $id)
    {
        $menu_category = MenuCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:menu_categories,name,' . $menu_category->id,
        ]);

        $menu_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => true,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->to(route('admin.menu-items.index') . '#categories')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $menu_category = MenuCategory::findOrFail($id);
        $menu_category->delete();
        return redirect()->to(route('admin.menu-items.index') . '#categories')->with('success', 'Category deleted successfully!');
    }

    public function show(string $id) {}
}
