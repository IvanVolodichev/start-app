<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\Manager\Config;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => Str::random(32),
                    'avatar' => $socialUser->getAvatar(),
                ]
            );
    
            Auth::login($user);
            
            $redirectUrl = auth()->user()->is_admin 
            ? route('dashboard', absolute: false) 
            : route('main', absolute: false);

            return redirect()->intended($redirectUrl);
    
        } catch (\Exception $e) {
            Log::error("OAuth error: {$e->getMessage()}");
            dd($e->getMessage());
        }
    }
}
