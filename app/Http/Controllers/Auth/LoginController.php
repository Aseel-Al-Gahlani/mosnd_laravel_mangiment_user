<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
     public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                return response()->json(['message' => 'Account not activated. Please check your email.'], 403);
            }

            return response()->json(['message' => 'Login successful!', 'user' => $user,"success"=> true]);
        }

        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
