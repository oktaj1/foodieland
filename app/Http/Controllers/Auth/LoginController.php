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

            // Optionally, set a cookie with the token
            $cookie = cookie('token', $token, config('sanctum.expiration'), '/', '.myapp.local', null, true);

            // Return JSON response with user data, token, and set cookie
            return response()->json($response)->withCookie($cookie);
        }

        // If authentication fails, return unauthorized response
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
