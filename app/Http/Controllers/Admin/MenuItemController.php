<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MenuItemsImport;
use App\Models\{MenuCategory, MenuItem};
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = MenuCategory::orderBy('order')->get();

        return view('admin.menu-items.index', compact('menuItems', 'categories'));
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\MenuItemsExport, 'menu-items.xlsx');
    }

    public function exportPdf()
    {
        $menuItems = MenuItem::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.menu-items.pdf', compact('menuItems'));
    }

    public function create()
    {
        $categories = MenuCategory::active()->ordered()->get();
        return view('admin.menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'nullable|in:veg,non-veg',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Create directory if it doesn't exist
            if (!file_exists(public_path('uploads/menu'))) {
                mkdir(public_path('uploads/menu'), 0755, true);
            }

            $image->move(public_path('uploads/menu'), $imageName);
            $imagePath = 'uploads/menu/' . $imageName;
        }

        MenuItem::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type ?? 'veg',
            'image' => $imagePath,
            'is_active' => true,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item created successfully!');
    }

    public function edit(MenuItem $menu_item)
    {
        $categories = MenuCategory::active()->ordered()->get();
        return view('admin.menu-items.edit', compact('menu_item', 'categories'));
    }

    public function update(Request $request, MenuItem $menu_item)
    {
        $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'type' => 'nullable|in:veg,non-veg',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type ?? 'veg',
            'is_active' => true,
            'order' => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($menu_item->image && file_exists(public_path($menu_item->image))) {
                unlink(public_path($menu_item->image));
            }

            // Create directory if it doesn't exist
            if (!file_exists(public_path('uploads/menu'))) {
                mkdir(public_path('uploads/menu'), 0755, true);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/menu'), $imageName);
            $data['image'] = 'uploads/menu/' . $imageName;
        }

        $menu_item->update($data);
        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menu_item)
    {
        if ($menu_item->image && file_exists(public_path($menu_item->image))) {
            unlink(public_path($menu_item->image));
        }
        $menu_item->delete();
        return redirect()->route('admin.menu-items.index')->with('success', 'Menu item deleted successfully!');
    }

    public function import()
    {
        return view('admin.menu-items.import');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="menu_items_template.csv"',
        ];

        $columns = ['category', 'name', 'price', 'description'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // Example row
            fputcsv($file, ['Evening Snacks', 'Paneer Tikka', '120', 'Description here']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        try {
            Excel::import(new MenuItemsImport, $request->file('file'));
            return redirect()->route('admin.menu-items.index')->with('success', 'Menu items imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Import failed validation: <br>' . implode('<br>', $messages));
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function deleteAllImported()
    {
        try {
            $deletedCount = MenuItem::where('is_imported', true)->delete();
            return redirect()
                ->route('admin.menu-items.index')
                ->with('success', "Successfully deleted {$deletedCount} imported menu items!");
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting imported items: ' . $e->getMessage());
        }
    }
}
