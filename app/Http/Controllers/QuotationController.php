<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display quotation for public sharing
     */
    public function show($token)
    {
        $quotation = Quotation::where('share_token', $token)->firstOrFail();

        return view('quotations.show', compact('quotation'));
    }

    /**
     * Generate WhatsApp share link for public quotation
     */
    public function whatsapp($token)
    {
        $quotation = Quotation::where('share_token', $token)->firstOrFail();

        $message = "Hello {$quotation->customer_name}, \n\n";
        $message .= "Please find your quotation details:\n";
        $message .= "Quotation No: {$quotation->quotation_number}\n";
        $message .= "Event: {$quotation->event_type}\n";
        $message .= 'Total Amount: ₹' . number_format($quotation->total, 2) . "\n\n";
        $message .= 'View full details: ' . route('quotations.show', $token) . "\n\n";
        $message .= 'Thank you for choosing Manam Catering Service!';

        $phone = preg_replace('/[^0-9]/', '', $quotation->customer_phone);
        $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);

        return redirect($whatsappUrl);
    }
}
