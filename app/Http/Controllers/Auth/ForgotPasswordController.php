<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        Log::info('Password reset request for email: ' . $request->email);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        Log::info('Password reset link status: ' . $status);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.', 'status' => __($status)], 200)
            : response()->json(['message' => 'Unable to send reset link', 'errors' => ['email' => __($status)]], 400);
    }
}
