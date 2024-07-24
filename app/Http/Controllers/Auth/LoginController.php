<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Attempt to authenticate a user based on provided email and password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Generate an API token for the authenticated user
            /** @var User $user */
            $token = $user->createToken('AuthToken')->plainTextToken;

            // Prepare response data
            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'Authenticated successfully',
            ];

            // Create the auth cookie
            $cookie = cookie(
                'auth_token',                       // Cookie name
                $token,                            // Cookie value
                config('sanctum.expiration'),      // Cookie expiration in minutes
                '/',                               // Cookie path
                null,                              // Cookie domain (null to leave it unset)
                false,                             // Secure (HTTPS only)
                true,                              // HttpOnly
                false,                             // Raw
                'lax'                              // SameSite attribute
            );

            // Return response with cookie
            return response()->json($response)->cookie($cookie);
        }

        // If authentication fails, return unauthorized response
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
