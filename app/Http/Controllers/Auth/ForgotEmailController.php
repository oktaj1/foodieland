<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailInfoMail;

class ForgotEmailController extends Controller
{
    public function sendEmailInfo(Request $request)
    {
        $request->validate([
            'email' => 'required|string|exists:users,email',
        ]);

        $user = User::where('user', $request->user)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Send email with user's email address
        Mail::to($user->email)->send(new EmailInfoMail($user));

        return response()->json(['message' => 'Email with account information sent.'], 200);
    }
}
