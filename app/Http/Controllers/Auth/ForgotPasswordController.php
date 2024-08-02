<?php 
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Send a reset password link to the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        $request->validate(['email' => 'required|email']);

        // Retrieve the user to send the email
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            // Generate a custom token
            $token = Str::random(60);
            $hashedToken = Hash::make($token); // Hash the token

            // Store the token in the password_reset_tokens table
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $hashedToken, 'created_at' => now()]
            );

            // Generate the password reset URL using the custom token
            $resetUrl = url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $request->email], false));

            // Send the reset password email using the custom Blade view
            Mail::to($user->email)->send(new ResetPasswordMail($user, $resetUrl));

            return response()->json(['message' => 'Password reset link sent']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
