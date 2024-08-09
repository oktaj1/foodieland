<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendContactSubmissionEmail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactSubmissionReceived;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Dispatch job to send email
        SendContactSubmissionEmail::dispatch($request->only(['name', 'email', 'message']));

        // Send email notification (if needed)
        Mail::to('your-email@example.com')->send(new ContactSubmissionReceived($request->all()));

        return response()->json(['message' => 'Contact form submitted successfully.']);
    }
}
