<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::orderBy('order')->get();
        return view('admin.hero-banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.hero-banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text_1' => 'nullable|string|max:255',
            'button_link_1' => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:255',
            'button_link_2' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/hero'), $imageName);
            $data['image'] = 'uploads/hero/' . $imageName;
        }

        HeroBanner::create($data);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Slider created successfully.');
    }

    public function edit(HeroBanner $heroBanner)
    {
        return view('admin.hero-banners.edit', compact('heroBanner'));
    }

    public function update(Request $request, HeroBanner $heroBanner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text_1' => 'nullable|string|max:255',
            'button_link_1' => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:255',
            'button_link_2' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($heroBanner->image && file_exists(public_path($heroBanner->image))) {
                unlink(public_path($heroBanner->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/hero'), $imageName);
            $data['image'] = 'uploads/hero/' . $imageName;
        }

        $heroBanner->update($data);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(HeroBanner $heroBanner)
    {
        if ($heroBanner->image && file_exists(public_path($heroBanner->image))) {
            unlink(public_path($heroBanner->image));
        }

        $heroBanner->delete();

        return redirect()->route('admin.hero-banners.index')->with('success', 'Slider deleted successfully.');
    }
}
