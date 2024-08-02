<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller

{
    public function verify($token, Request $request)
    {
        $email = $request->query('email');

        $tokenData = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();

        if (!$tokenData) {
            return response()->json(['message' => 'Invalid or expired password reset token.'], 400);
        }

        // Token is valid, you can show the reset password form here or return a response
        return response()->json(['message' => 'Password reset token verified. You can now reset your password.', 'token' => $token], 200);
    }
}
