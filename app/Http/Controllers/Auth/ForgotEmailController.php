<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailInfoJob;

class ForgotEmailController extends Controller
{
    public function sendEmailInfo(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Dispatch the job to send the email
        SendEmailInfoJob::dispatch($user);

        return response()->json(['message' => 'Email with account information sent.'], 200);
    }
}
