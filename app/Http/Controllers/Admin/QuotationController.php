<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

// Load FPDF library
if (!class_exists('FPDF')) {
    require_once app_path('Lib/fpdf.php');
}

class QuotationController extends Controller
{
    // Client Quotations (from bookings)
    public function clientIndex(Request $request)
    {
        $query = Quotation::clientQuotations()->with('booking');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('quotation_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('customer_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('customer_email', 'LIKE', '%' . $search . '%')
                    ->orWhere('event_type', 'LIKE', '%' . $search . '%');
            });
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.quotations.client-index', compact('quotations'));
    }

    // Manual Quotations
    public function index(Request $request)
    {
        $query = Quotation::manualQuotations();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('quotation_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('customer_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('customer_email', 'LIKE', '%' . $search . '%')
                    ->orWhere('event_type', 'LIKE', '%' . $search . '%');
            });
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.quotations.index', compact('quotations'));
    }

    public function create(Request $request)
    {
        $booking = null;
        $customer = null;

        if ($request->has('booking_id')) {
            $booking = \App\Models\Booking::find($request->booking_id);
        }

        if ($request->has('customer_id')) {
            $customer = \App\Models\Customer::find($request->customer_id);
        }

        $categories = \App\Models\MenuCategory::with(['items' => function ($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->orderBy('order')->get();

        $events = \App\Models\Event::where('is_active', true)->orderBy('order')->get();

        return view('admin.quotations.create', compact('booking', 'customer', 'categories', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'event_type' => 'nullable|string',
            'event_date' => 'nullable|date',
            'guest_count' => 'nullable|integer',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.is_extra' => 'nullable|boolean',
            'subtotal' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total' => 'required|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected',
        ]);

        Quotation::create($validated);

        return redirect()->route('admin.quotations.index')->with('success', 'Quotation created successfully!');
    }

    public function show(Quotation $quotation)
    {
        return view('admin.quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $categories = \App\Models\MenuCategory::with(['items' => function ($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->orderBy('order')->get();

        $events = \App\Models\Event::where('is_active', true)->orderBy('order')->get();

        return view('admin.quotations.edit', compact('quotation', 'categories', 'events'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'event_type' => 'nullable|string',
            'event_date' => 'nullable|date',
            'guest_count' => 'nullable|integer',
            'items' => 'required|array',
            'subtotal' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total' => 'required|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected',
        ]);

        $quotation->update($validated);

        return redirect()->route('admin.quotations.index')->with('success', 'Quotation updated successfully!');
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('admin.quotations.index')->with('success', 'Quotation deleted successfully!');
    }

    // Generate quotation from booking
    public function generateFromBooking(Booking $booking)
    {
        // Parse selected items into array format and fetch prices
        $items = [];
        if ($booking->selected_items) {
            $selectedItems = explode(',', $booking->selected_items);
            foreach ($selectedItems as $item) {
                $itemName = trim($item);

                // Try to find menu item by name to get price
                $menuItem = \App\Models\MenuItem::where('name', 'LIKE', '%' . $itemName . '%')
                    ->orWhere('name', 'LIKE', $itemName . '%')
                    ->first();

                $price = $menuItem ? (float) $menuItem->price : 50.0;  // Default ₹50 per item if not found

                $items[] = [
                    'name' => $itemName,
                    'quantity' => $booking->guest_count ?? 1,
                    'price' => $price,
                ];
            }
        }

        // If no items, add a placeholder
        if (empty($items)) {
            $items[] = [
                'name' => 'Catering Service',
                'quantity' => $booking->guest_count ?? 1,
                'price' => 50.0,  // Default price per person
            ];
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        $tax = $subtotal * 0.18;  // 18% GST
        $discount = 0;
        $total = $subtotal + $tax - $discount;

        // Create quotation
        $quotation = Quotation::create([
            'booking_id' => $booking->id,
            'customer_name' => $booking->name,
            'customer_email' => $booking->email,
            'customer_phone' => $booking->contact_number,
            'event_type' => $booking->event_type,
            'event_date' => $booking->event_date,
            'guest_count' => $booking->guest_count,
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
            'notes' => $booking->special_requests ?? 'Please review and update pricing.',
            'status' => 'draft',
        ]);

        return redirect()
            ->route('admin.client-quotations.index')
            ->with('success', 'Quotation generated successfully! You can now edit and update prices.');
    }

    // --- PDF GENERATION LOGIC WITH FPDF ---

    // --- PDF GENERATION LOGIC WITH FPDF ---

    private function generatePDF(Quotation $quotation)
    {
        // Clear any previous output buffering
        if (ob_get_length()) {
            ob_clean();
        }

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 10);

        // Colors
        $colorGold = [139, 111, 71];  // #8B6F47
        $colorDark = [26, 26, 26];  // #1a1a1a
        $colorGray = [107, 114, 128];  // #6b7280
        $colorLight = [229, 231, 235];  // #e5e7eb
        $colorBg = [249, 250, 251];  // #f9fafb

        // --- HEADER ---
        // Logo
        $logoPath = public_path('assets/images/main/logo.png');
        if (file_exists($logoPath)) {
            try {
                $imageInfo = getimagesize($logoPath);
                $imageType = $imageInfo[2] ?? null;
                if ($imageType === IMAGETYPE_PNG) {
                    $pdf->Image($logoPath, 10, 10, 25, 0, 'PNG');
                } elseif ($imageType === IMAGETYPE_JPEG) {
                    $pdf->Image($logoPath, 10, 10, 25, 0, 'JPG');
                }
            } catch (\Throwable $e) {
            }
        }

        // Company Details (Left)
        $pdf->SetXY(40, 10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(0, 5, 'MANAM CATERING SERVICE', 0, 1);

        $pdf->SetXY(40, 16);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);
        $pdf->MultiCell(0, 4, "123 Culinary Road, Food District\nCoimbatore, Tamil Nadu 841002\nGSTIN: 33AAAAAA0000A1Z5", 0, 'L');

        // Invoice Title & Status (Right)
        $pdf->SetXY(120, 10);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(80, 10, 'QUOTATION', 0, 1, 'R');

        $pdf->SetXY(120, 20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor($colorGold[0], $colorGold[1], $colorGold[2]);
        $pdf->Cell(80, 5, '#' . $quotation->quotation_number, 0, 1, 'R');

        // Status Badge
        $pdf->SetXY(120, 26);
        $pdf->SetFont('Arial', 'B', 8);
        $status = strtoupper($quotation->status);
        if ($status == 'ACCEPTED')
            $pdf->SetTextColor(22, 163, 74);
        elseif ($status == 'REJECTED')
            $pdf->SetTextColor(220, 38, 38);
        else
            $pdf->SetTextColor(139, 111, 71);
        $pdf->Cell(80, 5, $status, 0, 1, 'R');

        $pdf->SetDrawColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10, 35, 200, 35);

        // --- INFO BOXES ---
        $yStart = 45;
        $boxHeight = 35;
        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor($colorLight[0], $colorLight[1], $colorLight[2]);

        // Box 1: Customer Info
        $pdf->Rect(10, $yStart, 90, $boxHeight);  // Border

        $pdf->SetXY(15, $yStart + 5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor($colorGold[0], $colorGold[1], $colorGold[2]);
        $pdf->Cell(80, 6, 'Customer Information', 0, 1);

        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);

        $pdf->SetXY(15, $yStart + 13);
        $pdf->Cell(20, 5, 'Name:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(60, 5, $quotation->customer_name, 0, 1);

        $pdf->SetXY(15, $yStart + 19);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);
        $pdf->Cell(20, 5, 'Email:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(60, 5, $quotation->customer_email, 0, 1);

        $pdf->SetXY(15, $yStart + 25);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);
        $pdf->Cell(20, 5, 'Phone:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(60, 5, $quotation->customer_phone ?? 'N/A', 0, 1);

        // Box 2: Event Details
        $pdf->Rect(110, $yStart, 90, $boxHeight);  // Border

        $pdf->SetXY(115, $yStart + 5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor($colorGold[0], $colorGold[1], $colorGold[2]);
        $pdf->Cell(80, 6, 'Event Details', 0, 1);

        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);

        $pdf->SetXY(115, $yStart + 13);
        $pdf->Cell(25, 5, 'Event Type:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(55, 5, $quotation->event_type ?? 'General', 0, 1);

        $pdf->SetXY(115, $yStart + 19);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);
        $pdf->Cell(25, 5, 'Event Date:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(55, 5, $quotation->event_date ? $quotation->event_date->format('F d, Y') : 'TBD', 0, 1);

        $pdf->SetXY(115, $yStart + 25);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);
        $pdf->Cell(25, 5, 'Guest Count:', 0, 0);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->Cell(55, 5, $quotation->guest_count ?? 'TBD', 0, 1);

        $pdf->SetY($yStart + $boxHeight + 10);

        // --- ITEMS HEADING ---
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor($colorGold[0], $colorGold[1], $colorGold[2]);
        $pdf->Cell(0, 10, 'Items', 0, 1);

        // --- TABLE ---
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(249, 250, 251);  // Very light gray
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
        $pdf->SetDrawColor($colorLight[0], $colorLight[1], $colorLight[2]);

        // Header
        $pdf->Cell(15, 10, '#', 0, 0, 'C', true);
        $pdf->Cell(85, 10, 'ITEM NAME', 0, 0, 'L', true);
        $pdf->Cell(30, 10, 'QUANTITY', 0, 0, 'C', true);
        $pdf->Cell(30, 10, 'PRICE', 0, 0, 'R', true);
        $pdf->Cell(30, 10, 'TOTAL', 0, 1, 'R', true);

        // Rows
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);  // Dark text

        $lineHeight = 10;

        if ($quotation->items && count($quotation->items) > 0) {
            foreach ($quotation->items as $index => $item) {
                // Bottom border only
                $x = $pdf->GetX();
                $y = $pdf->GetY();

                $pdf->Cell(15, $lineHeight, $index + 1, 0, 0, 'C');

                // Bold Item Name
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(85, $lineHeight, $item['name'], 0, 0, 'L');
                $pdf->SetFont('Arial', '', 9);

                $pdf->Cell(30, $lineHeight, $item['quantity'], 0, 0, 'C');
                $pdf->Cell(30, $lineHeight, number_format($item['price'], 2), 0, 0, 'R');

                // Bold Total
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, $lineHeight, number_format($item['quantity'] * $item['price'], 2), 0, 1, 'R');
                $pdf->SetFont('Arial', '', 9);

                // Draw line below
                $pdf->SetDrawColor($colorLight[0], $colorLight[1], $colorLight[2]);
                $pdf->Line(10, $y + $lineHeight, 200, $y + $lineHeight);
            }
        } else {
            $pdf->Cell(190, $lineHeight, 'No items added', 0, 1, 'C');
            $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        }

        $pdf->Ln(5);

        // --- FOOTER SECTION ---
        $yBottom = $pdf->GetY();

        // Notes (Left) - Optional: Removed colored background to match print clean look or keep it light
        if ($quotation->notes) {
            $pdf->SetXY(10, $yBottom);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor($colorGold[0], $colorGold[1], $colorGold[2]);
            $pdf->Cell(90, 8, 'Notes', 0, 1);

            $pdf->SetFont('Arial', '', 9);
            $pdf->SetTextColor(120, 53, 15);  // Brownish text for notes
            $pdf->MultiCell(90, 5, $quotation->notes, 0, 'L');
        }

        // Totals (Right)
        $pdf->SetXY(110, $yBottom);
        $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);

        // Subtotal
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 8, 'Subtotal:', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(40, 8, 'Rs. ' . number_format($quotation->subtotal, 2), 0, 1, 'R');
        $pdf->SetX(110);

        // Tax
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(50, 8, 'Tax (18% GST):', 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(40, 8, 'Rs. ' . number_format($quotation->tax, 2), 0, 1, 'R');
        $pdf->SetX(110);

        // Discount
        if ($quotation->discount > 0) {
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(50, 8, 'Discount:', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetTextColor(220, 38, 38);  // Red
            $pdf->Cell(40, 8, '- Rs. ' . number_format($quotation->discount, 2), 0, 1, 'R');
            $pdf->SetTextColor($colorDark[0], $colorDark[1], $colorDark[2]);
            $pdf->SetX(110);
        }

        // Divider
        $pdf->SetDrawColor($colorLight[0], $colorLight[1], $colorLight[2]);
        $pdf->Line(110, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(2);

        // Grand Total
        $pdf->SetX(110);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 10, 'Total Amount:', 0, 0, 'L');
        $pdf->SetTextColor($colorGold[0], $colorGold[1], $colorGold[2]);
        $pdf->Cell(40, 10, 'Rs. ' . number_format($quotation->total, 2), 0, 1, 'R');

        // Footer Text
        $pdf->SetY(-20);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetTextColor($colorGray[0], $colorGray[1], $colorGray[2]);
        $pdf->Cell(0, 5, 'Thank you for choosing Manam Catering Service.', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Generated on ' . date('d-m-Y H:i A'), 0, 1, 'C');

        return $pdf->Output('S');
    }

    // Download PDF
    public function downloadPDF(Quotation $quotation)
    {
        try {
            $pdfContent = $this->generatePDF($quotation);
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="quotation-' . $quotation->quotation_number . '.pdf"');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'PDF Generation failed: ' . $e->getMessage());
        }
    }

    // Generate WhatsApp share link with PDF
    public function shareWhatsApp(Quotation $quotation)
    {
        try {
            $pdfContent = $this->generatePDF($quotation);
            $fileName = 'quotation-' . $quotation->quotation_number . '.pdf';

            $tempDir = storage_path('app/public/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $filePath = $tempDir . '/' . $fileName;
            file_put_contents($filePath, $pdfContent);

            $pdfUrl = asset('storage/temp/' . $fileName);

            $message = "Hello {$quotation->customer_name}, \n\n";
            $message .= "Your quotation from Manam Catering Service is ready!\n\n";
            $message .= "Quotation No: {$quotation->quotation_number}\n";
            $message .= "Event: {$quotation->event_type}\n";
            $message .= 'Total Amount: ' . $quotation->formatted_total . "\n\n";
            $message .= "Download: {$pdfUrl}\n";
            $message .= 'Thank you!';

            $phone = preg_replace('/[^0-9]/', '', $quotation->customer_phone);
            if (strlen($phone) == 10)
                $phone = '91' . $phone;

            return redirect("https://wa.me/{$phone}?text=" . urlencode($message));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'WhatsApp Share failed: ' . $e->getMessage());
        }
    }

    // Send email with PDF attachment
    public function sendEmail(Request $request, Quotation $quotation)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $pdfContent = $this->generatePDF($quotation);
            $fileName = 'quotation-' . $quotation->quotation_number . '.pdf';

            // Send email with PDF attachment
            Mail::send('admin.quotations.email', ['quotation' => $quotation], function ($message) use ($quotation, $request, $pdfContent, $fileName) {
                $message
                    ->to($request->email)
                    ->subject('Quotation - ' . $quotation->quotation_number . ' - Manam Catering Service')
                    ->attachData($pdfContent, $fileName, [
                        'mime' => 'application/pdf',
                    ]);
            });

            return redirect()->back()->with('success', 'Quotation PDF sent via email successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
