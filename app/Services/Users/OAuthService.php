<?php

namespace App\Services\Users;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuthService
{
    public function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleGitHubCallback(): RedirectResponse
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            $user = User::where('github_id', $githubUser->id)->first();

            if (!$user) {
                $user = new User;
                $user->github_id = $githubUser->id;
                $user->username = $githubUser->name;

                try {
                    $user->save();
                } catch (Exception) {
                    $user->username = $githubUser->name.'_'.Str::random(5);
                    $user->save();
                }
            }

            Auth::login($user);

            return redirect()->route('home');
        } catch (Exception) {
            return redirect()->route('auth.login');
        }
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if (!$user) {
                $user = new User;
                $user->google_id = $googleUser->id;
                $user->username = $googleUser->name;

                try {
                    $user->save();
                } catch (Exception) {
                    $user->username = $googleUser->name.'_'.Str::random(5);
                    $user->save();
                }
            }

            Auth::login($user);

            return redirect()->route('home');
        } catch (Exception) {
            return redirect()->route('auth.login');
        }
    }

    public function handleDiscordCallback(): RedirectResponse
    {
        try {
            $discordUser = Socialite::driver('discord')->user();

            $user = User::where('discord_id', $discordUser->id)->first();

            if (!$user) {
                $user = new User;
                $user->discord_id = $discordUser->id;
                $user->username = $discordUser->name;

                Storage::disk('public')->put('avatars/'.$discordUser->id.'.png', file_get_contents($discordUser->avatar));

                try {
                    $user->save();
                } catch (Exception) {
                    $user->username = $discordUser->name.'_'.Str::random(5);
                    $user->save();
                }
            }

            Auth::login($user);

            return redirect()->route('home');
        } catch (Exception) {
            return redirect()->route('auth.login');
        }
    }
}
