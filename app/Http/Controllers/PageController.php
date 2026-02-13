<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MenuCategory, Event, TeamMember, Stat, Faq, SiteSetting};

class PageController extends Controller
{
    public function menu()
    {
        $menuCategories = MenuCategory::active()->ordered()->with('activeMenuItems')->get();
        return view('menu', compact('menuCategories'));
    }

    public function events()
    {
        $events = Event::active()->ordered()->get();
        return view('events', compact('events'));
    }

    public function about()
    {
        $teamMembers = TeamMember::active()->ordered()->get();
        $stats = Stat::ordered()->get();
        $siteSettings = SiteSetting::first();
        return view('about', compact('teamMembers', 'stats', 'siteSettings'));
    }

    public function faqs()
    {
        $faqs = Faq::active()->ordered()->get();
        return view('faqs', compact('faqs'));
    }

    public function contact()
    {
        $siteSettings = SiteSetting::first();
        return view('contact', compact('siteSettings'));
    }
}
