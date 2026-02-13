<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{TeamMember, Testimonial, Faq, MenuCategory, SiteSetting};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Team Member Controller
class TeamMemberControllerImpl extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::orderBy('order')->get();
        return view('admin.team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/team'), $imageName);
            $imagePath = 'uploads/team/' . $imageName;
        }

        TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'image' => $imagePath,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.team-members.index')->with('success', 'Team member created successfully!');
    }

    public function edit(TeamMember $team_member)
    {
        return view('admin.team-members.edit', compact('team_member'));
    }

    public function update(Request $request, TeamMember $team_member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($team_member->image && file_exists(public_path($team_member->image))) {
                unlink(public_path($team_member->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/team'), $imageName);
            $data['image'] = 'uploads/team/' . $imageName;
        }

        $team_member->update($data);
        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $team_member)
    {
        if ($team_member->image && file_exists(public_path($team_member->image))) {
            unlink(public_path($team_member->image));
        }
        $team_member->delete();
        return redirect()->route('admin.team-members.index')->with('success', 'Team member deleted successfully!');
    }
}

// Testimonial Controller  
class TestimonialControllerImpl extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/testimonials'), $imageName);
            $imagePath = 'uploads/testimonials/' . $imageName;
        }

        Testimonial::create([
            'name' => $request->name,
            'role' => $request->role,
            'image' => $imagePath,
            'message' => $request->message,
            'rating' => $request->rating,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'message' => $request->message,
            'rating' => $request->rating,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ];

       if ($request->hasFile('image')) {
            if ($testimonial->image && file_exists(public_path($testimonial->image))) {
                unlink(public_path($testimonial->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/testimonials'), $imageName);
            $data['image'] = 'uploads/testimonials/' . $imageName;
        }

        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && file_exists(public_path($testimonial->image))) {
            unlink(public_path($testimonial->image));
        }
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully!');
    }
}

// FAQ Controller
class FaqControllerImpl extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully!');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully!');
    }
}

// Menu Category Controller
class MenuCategoryControllerImpl extends Controller
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
            'name' => 'required|string|max:255',
        ]);

        MenuCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.menu-categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(MenuCategory $menu_category)
    {
        return view('admin.menu-categories.edit', compact('menu_category'));
    }

    public function update(Request $request, MenuCategory $menu_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $menu_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.menu-categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(MenuCategory $menu_category)
    {
        $menu_category->delete();
        return redirect()->route('admin.menu-categories.index')->with('success', 'Category deleted successfully!');
    }
}

// Site Setting Controller
class SiteSettingControllerImpl extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $settings = SiteSetting::first();
        if ($settings) {
            $settings->update($request->all());
        } else {
            SiteSetting::create($request->all());
        }

        return redirect()->route('admin.site-settings.edit')->with('success', 'Site settings updated successfully!');
    }
}
