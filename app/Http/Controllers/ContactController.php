<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        try {
            // Save to database
            Contact::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'] ?? 'Contact Enquiry',
                'phone' => $data['phone'],
                'message' => $data['message'],
                'is_read' => false,
            ]);

            // Send email
            Mail::to('vmgitsolutions@gmail.com')->send(new ContactMail($data));

            return back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an issue sending your message. Please try again later.');
        }
    }
}
