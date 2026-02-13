<?php

namespace App\Http\Controllers;

use App\Models\{
    HeroBanner,
    Service,
    PopularDish,
    Stat,
    MenuCategory,
    Event,
    TeamMember,
    Testimonial,
    SiteSetting
};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanners = HeroBanner::where('is_active', true)->orderBy('order')->get();
        $services = Service::active()->ordered()->get();
        $popularDishes = PopularDish::active()->ordered()->limit(6)->get();
        $stats = Stat::ordered()->get();

        // Get menu items preview from each category
        $menuCategories = MenuCategory::active()->ordered()->with(['activeMenuItems' => function ($q) {
            $q->limit(10);
        }])->get();

        $events = Event::active()->ordered()->limit(8)->get();
        $teamMembers = TeamMember::active()->ordered()->get();
        $testimonials = Testimonial::active()->ordered()->get();
        $siteSettings = SiteSetting::first();

        return view('home', compact(
            'heroBanners',
            'services',
            'popularDishes',
            'stats',
            'menuCategories',
            'events',
            'teamMembers',
            'testimonials',
            'siteSettings'
        ));
    }
}
