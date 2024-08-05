<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailInfoMail;
use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailInfoJob;
=======
use Illuminate\Support\Facades\Mail;
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

class ForgotEmailController extends Controller
{
    public function sendEmailInfo(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

<<<<<<< HEAD
        // Dispatch the job to send the email
        SendEmailInfoJob::dispatch($user);
=======
        // TODO: Send the email with a job/queue
        // Send email with user's email address
        Mail::to($user->email)->send(new EmailInfoMail($user));
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736

        return response()->json(['message' => 'Email with account information sent.'], 200);
    }
}
