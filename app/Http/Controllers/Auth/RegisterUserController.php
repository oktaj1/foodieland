<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ]);

        // Create a new user record
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate an API token for the user
        $token = $user->createToken('AuthToken')->plainTextToken;

        // Optionally, send verification email (if your application requires it)
        $verification_token = Str::random(40);
        $hashed_verification_token = bcrypt($verification_token);

        // You can perform additional actions here, such as sending emails or syncing roles

        // Return a JSON response with success message and token
        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
