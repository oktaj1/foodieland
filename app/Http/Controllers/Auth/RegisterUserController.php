<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // Added validation for name
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ]);

        // Create a new user record
        $user = User::create([
            'name' => $request->name, // Save the name
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate an API token for the user
        $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}

