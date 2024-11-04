<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Session;
class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        $user = User::updateOrCreate(
            [
                'email' => $socialUser->getEmail(),
            ]
            ,
            [
                'name' => $socialUser->getName() ?? 'unknown',
                'email' => $socialUser->getEmail(),
                'email_verified_at' => now(),
                'password' => null,
            ]
        );
        Auth::login($user);
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return redirect(route('dashboard'));
    }
}
