<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)
            ->redirect();
    }

    public function callback($provider)
    {
        // $provider_user = Socialite::driver($provider)->stateless()->user();
        // dd($provider_user);
        try {
            $provider_user = Socialite::driver($provider)->user();

            $user = User::where([
                'provider' => $provider,
                'provider_id' => $provider_user->id
            ])->first();

            if (!$user) {
                $user = User::create([
                    'name' => $provider_user->name,
                    'email' => $provider_user->email,
                    'password' => Hash::make(Str::random(8)),
                    'provider' => $provider,
                    'provider_id' => $provider_user->id,
                    'provider_token' => $provider_user->token,
                ]);
            }

            Auth::login($user);

            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }
}