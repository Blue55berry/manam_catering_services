<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '_' . $icon->getClientOriginalName();
            $icon->move(public_path('uploads/services'), $iconName);
            $iconPath = 'uploads/services/' . $iconName;
        }

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $iconPath,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ];

        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($service->icon && file_exists(public_path($service->icon))) {
                unlink(public_path($service->icon));
            }
            $icon = $request->file('icon');
            $iconName = time() . '_' . $icon->getClientOriginalName();
            $icon->move(public_path('uploads/services'), $iconName);
            $data['icon'] = 'uploads/services/' . $iconName;
        }

        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        if ($service->icon && file_exists(public_path($service->icon))) {
            unlink(public_path($service->icon));
        }
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully!');
    }
}
