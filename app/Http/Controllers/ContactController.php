<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSubmission; // Import the model if using database storage
use Illuminate\Support\Facades\Mail; // Import for sending emails
use App\Mail\ContactSubmissionReceived; // Import your email class

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
        Mail::to('your-email@example.com')->send(new ContactSubmissionReceived($request->all()));

        return response()->json(['message' => 'Contact form submitted successfully.']);
    }
}

