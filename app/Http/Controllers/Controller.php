<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function showInvalidQuery(string $message, $code = 400)
    {
        if(true) {
            return response()->json(['message' => $message], 500);
        }
        return response()->json(['message' => 'Something went wrong'], 500);
    }
}
