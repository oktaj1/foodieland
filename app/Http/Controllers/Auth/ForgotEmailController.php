<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailInfoMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotEmailController extends Controller
{
    public function sendEmailInfo(Request $request)
    {
        $request->validate([
            'email' => 'required|string|exists:users,email',
        ]);

        $user = User::where('user', $request->user)->first();

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // TODO: Send the email with a job/queue
        // Send email with user's email address
        Mail::to($user->email)->send(new EmailInfoMail($user));

        return response()->json(['message' => 'Email with account information sent.'], 200);
    }
}
