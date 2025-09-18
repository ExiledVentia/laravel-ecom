<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword; 
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.forgot-password', ['request' => $request]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Password::createToken($user);
        Mail::to($user->email)->send(new ResetPassword($token));
        return back()->with(['status' => 'We have e-mailed your password reset link!']);
    }

}
