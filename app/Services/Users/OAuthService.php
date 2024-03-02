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
    /**
     * Redirect the user to the authentication page of the specified provider.
     *
     * @param string $provider The name of the social provider.
     * @return RedirectResponse The redirect response.
     */
    public function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from GitHub authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Handle the Google callback.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Handles the callback from Discord authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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
