<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\AccountActivation;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => false, // Set to false until email is verified
        ]);

        // Send activation email using PHPMailer or Laravel's built-in mail function
        // Mail::to($user->email)->send(new AccountActivation($user));

        return response()->json(['message' => 'Registration successful! Please check your email to activate your account.',"success"=> true]);
    }

    public function activate($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->is_active = true;
        $user->activation_token = null;
        $user->save();

        return response()->json(['message' => 'Account activated successfully!']);
    }
}
