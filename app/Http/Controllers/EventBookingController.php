<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\MenuCategory;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventBookingController extends Controller
{
    /**
     * Display booking form for a specific event or general.
     */
    public function create($eventId = null)
    {
        $event = $eventId ? Event::find($eventId) : null;
        $categories = MenuCategory::active()->ordered()->with(['activeMenuItems'])->get();
        $packages = \App\Models\Package::where('is_active', true)->orderBy('price')->get();
        return view('events.book', compact('event', 'categories', 'packages'));
    }

    /**
     * Store a new event booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Client Details
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            // Step 2: Event Details
            'event_id' => 'nullable|exists:events,id',
            'event_type' => 'required|string|in:Wedding,Corporate Event,Celebration,Social Gathering',
            'event_date' => 'required|date|after:today',
            'guest_count' => 'required|integer|min:1|max:10000',
            'package_id' => 'required|exists:packages,id', // Added
            'food_preference' => 'required|string|max:50',
            'selected_items' => 'nullable|string',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $validated['status'] = 'pending';

        $booking = Booking::create($validated);

        // Auto-generate quotation from booking
        $this->createQuotationFromBooking($booking);

        return redirect()
            ->route('home')
            ->with('success', 'Thank you for booking Manam Catering Services! We appreciate your trust in us and will contact you shortly to confirm your event details.');
    }

    /**
     * Store booking via AJAX.
     */
    public function ajaxStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Step 1: Client Details
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            // Step 2: Event Details
            'event_id' => 'nullable|exists:events,id',
            'event_type' => 'required|string|in:Wedding,Corporate Event,Celebration,Social Gathering',
            'event_date' => 'required|date|after:today',
            'guest_count' => 'required|integer|min:1|max:10000',
            'package_id' => 'required|exists:packages,id', // Added
            'food_preference' => 'required|string|max:50',
            'selected_items' => 'nullable|string',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $validated['status'] = 'pending';

        $booking = Booking::create($validated);

        // Auto-generate quotation from booking
        $quotation = $this->createQuotationFromBooking($booking);

        return response()->json([
            'success' => true,
            'message' => 'Your booking request has been submitted successfully! We will contact you shortly.',
            'booking_id' => $booking->id,
            'quotation_id' => $quotation->id
        ], 201);
    }

    /**
     * Validate step 1 data via AJAX.
     */
    public function validateStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Step 1 validated successfully'
        ]);
    }

    /**
     * Validate step 2 data via AJAX.
     */
    public function validateStep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_type' => 'required|string|in:Wedding,Corporate Event,Celebration,Social Gathering',
            'event_date' => 'required|date|after:today',
            'guest_count' => 'required|integer|min:1|max:10000',
            'package_id' => 'required|exists:packages,id', // Added
            'food_preference' => 'required|string|max:50',
            'selected_items' => 'nullable|string',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Step 2 validated successfully'
        ]);
    }

    /**
     * Create a quotation from a booking.
     */
    private function createQuotationFromBooking(Booking $booking)
    {
        $package = \App\Models\Package::find($booking->package_id);
        
        // Calculate pricing
        $pricePerGuest = $package ? $package->price : 0;
        $subtotal = $booking->guest_count * $pricePerGuest;
        $taxRate = 0.18;  // 18% GST
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        // Prepare items array
        $items = [];
        if ($package) {
            $items[] = [
                'name' => $package->name . ' (' . $package->type . ')',
                'quantity' => $booking->guest_count,
                'price' => $package->price,
                'total' => $subtotal
            ];
        }

        // Combine notes
        $notes = '';
        if ($booking->special_requests) {
            $notes .= 'Special Requests: ' . $booking->special_requests;
        }
        $notes .= "\n\nAuto-generated from Booking #" . $booking->id . "\nPackage: " . ($package ? $package->name : 'Unknown');

        // Create quotation
        $quotation = Quotation::create([
            'customer_name' => $booking->name,
            'customer_email' => $booking->email,
            'customer_phone' => $booking->contact_number,
            'event_type' => $booking->event_type,
            'event_date' => $booking->event_date,
            'guest_count' => $booking->guest_count,
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => 0,
            'total' => $total,
            'notes' => $notes,
            'status' => 'draft',
            'booking_id' => $booking->id,
            'customer_id' => null // Could link to customer if exists
        ]);

        return $quotation;
    }
}
