<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Service, MenuItem, Event, Booking, Contact, TeamMember, Testimonial};

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'services' => Service::count(),
            'menu_items' => MenuItem::count(),
            'events' => Event::count(),
            'team_members' => TeamMember::count(),
            'testimonials' => Testimonial::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'total_bookings' => Booking::count(),
            'total_orders' => \App\Models\Order::count(),
            'revenue' => \App\Models\Order::sum('total'),
        ];

        $recentBookings = Booking::orderBy('created_at', 'desc')->limit(5)->get();
        $recentContacts = Contact::orderBy('created_at', 'desc')->limit(5)->get();
        $recentOrders = \App\Models\Order::orderBy('created_at', 'desc')->limit(5)->get();
        $menuItems = MenuItem::orderBy('created_at', 'desc')->limit(5)->get();

        // Real-time data for charts

        // Get bookings by event type for revenue chart
        $bookingsByEventType = Booking::selectRaw('event_type, COUNT(*) as count')
            ->groupBy('event_type')
            ->get()
            ->pluck('count', 'event_type')
            ->toArray();

        // Get menu items by category for sales chart
        $menuByCategory = MenuItem::with('category')
            ->get()
            ->groupBy(function ($item) {
                return $item->category ? $item->category->name : 'Uncategorized';
            })
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();

        // Get recent bookings status breakdown
        $bookingsByStatus = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get bookings trend (XY Graph data - Bookings per month)
        $bookingsPerMonth = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $monthlyBookings = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyBookings[$i] = $bookingsPerMonth[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'recentContacts',
            'recentOrders',
            'menuItems',
            'bookingsByEventType',
            'menuByCategory',
            'bookingsByStatus',
            'monthlyBookings'
        ));
    }
}
