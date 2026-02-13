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
        return view('events.book', compact('event', 'categories'));
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
            'food_preference' => 'required|string|in:Vegetarian',
            'dish_suggestions' => 'nullable|string|max:1000',
            'special_requests' => 'nullable|string|max:1000',
            'selected_items' => 'nullable|array',
        ]);

        if (isset($validated['selected_items'])) {
            $validated['selected_items'] = implode(', ', $validated['selected_items']);
        }

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
            'food_preference' => 'required|string|in:Vegetarian',
            'dish_suggestions' => 'nullable|string|max:1000',
            'special_requests' => 'nullable|string|max:1000',
            'selected_items' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if (isset($validated['selected_items'])) {
            $validated['selected_items'] = implode(', ', $validated['selected_items']);
        }

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
            'food_preference' => 'required|string|in:Vegetarian',
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
        // Calculate pricing: ₹500 per guest as base estimate
        $pricePerGuest = 500;
        $subtotal = $booking->guest_count * $pricePerGuest;
        $taxRate = 0.18;  // 18% GST
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        // Prepare items array from selected items
        $items = [];
        if ($booking->selected_items) {
            $selectedItems = explode(', ', $booking->selected_items);
            foreach ($selectedItems as $item) {
                $items[] = [
                    'name' => $item,
                    'quantity' => $booking->guest_count,
                    'price' => 0,  // To be updated by admin
                    'total' => 0
                ];
            }
        }

        // Combine notes
        $notes = '';
        if ($booking->dish_suggestions) {
            $notes .= 'Dish Suggestions: ' . $booking->dish_suggestions . "\n\n";
        }
        if ($booking->special_requests) {
            $notes .= 'Special Requests: ' . $booking->special_requests;
        }
        $notes .= "\n\nAuto-generated from Booking #" . $booking->id . "\nThis is an estimated quotation. Admin will finalize pricing.";

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
        ]);

        return $quotation;
    }
}
