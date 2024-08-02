<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission; // Import the model if using database storage
use Illuminate\Http\Request; // Import for sending emails
use Illuminate\Support\Facades\Mail; // Import your email class

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Save to database (optional)
        ContactSubmission::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // Send email notification
        // TODO: use queue/jobs to send emails in the background
        Mail::to('your-email@example.com')->send(new ContactSubmissionReceived($request->all()));

        return response()->json(['message' => 'Contact form submitted successfully.']);
    }
}
