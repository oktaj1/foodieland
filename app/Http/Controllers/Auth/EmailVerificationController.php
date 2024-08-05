<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
<<<<<<< HEAD
<<<<<<< HEAD
    public function verify(Request $request, User $user)
=======
=======
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
    //TODO: Use Model Binding
    public function verify(Request $request, $id)
>>>>>>> 1a78a8badddf86bdfa98e2e327925e94f8b53736
    {
        if (! hash_equals((string) $request->route('hash'), sha1($user->email))) {
            return response()->json(['message' => 'Invalid verification link.'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email successfully verified.'], 200);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification email resent.']);
    }
}
