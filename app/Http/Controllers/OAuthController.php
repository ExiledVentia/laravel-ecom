<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user(); // If this shows an error just ignore it.

            $user = User::where('oauth_id', $googleUser->getId())->first();

            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    $user->update([
                        'oauth_id' => $googleUser->getId(),
                        'oauth_provider' => 'google',
                    ]);
                } else {
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'oauth_id' => $googleUser->getId(),
                        'oauth_provider' => 'google',
                        'password' => bcrypt(str()->random(16)),
                    ]);
                }
            }

            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('auth/login')->with('error', 'Google Login Failed.');
        }
    }
}
