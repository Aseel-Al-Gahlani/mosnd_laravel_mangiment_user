<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function show()
    {
        return response()->json(Auth::user());
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'sometimes|required|unique:users,username,' . $user->id,
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('username', 'email'));

        return response()->json(['message' => 'Profile updated successfully!', 'user' => $user,"success"=> true]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully!',"success"=> true]);
    }
}
