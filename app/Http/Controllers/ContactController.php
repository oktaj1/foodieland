<?php

namespace App\Http\Controllers;

<<<<<<< HEAD

use Illuminate\Http\Request;
use App\Jobs\SendContactSubmissionEmail;
use Illuminate\Support\Facades\Validator;
=======
use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission; // Import the model if using database storage
use Illuminate\Http\Request; // Import for sending emails
use Illuminate\Support\Facades\Mail; // Import your email class
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

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

<<<<<<< HEAD
        // Dispatch job to send email
        SendContactSubmissionEmail::dispatch($request->only(['name', 'email', 'message']));

        return response()->json(['message' => 'Contact form submitted successfully.']);
    }
}
=======
        // Send email notification
        // TODO: use queue/jobs to send emails in the background
        Mail::to('your-email@example.com')->send(new ContactSubmissionReceived($request->all()));

        return response()->json(['message' => 'Contact form submitted successfully.']);
    }
}
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
