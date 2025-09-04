<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('oauth_id', $socialUser->getId())
                ->where('oauth_provider', $provider)
                ->first();

            if (!$user) {
                $user = User::where('email', $socialUser->getEmail())->first();

                if ($user) {
                    $user->update([
                        'oauth_id' => $socialUser->getId(),
                        'oauth_provider' => $provider,
                    ]);
                } else {
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'oauth_id' => $socialUser->getId(),
                        'oauth_provider' => $provider,
                        'password' => bcrypt(str()->random(16)),
                    ]);
                }
            }

            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'OAuth login failed.');
        }
    }
}
