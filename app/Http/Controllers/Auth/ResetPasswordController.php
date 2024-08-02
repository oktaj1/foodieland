<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Retrieve the token from the password_reset_tokens table
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData || !Hash::check($request->token, $tokenData->token)) {
            return response()->json(['message' => 'Invalid token or email'], 400);
        }

        // Reset the user's password
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the token so it can't be used again
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Password has been reset.'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
