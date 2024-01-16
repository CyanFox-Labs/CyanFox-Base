<?php

namespace App\Helpers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthHelper
{

    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleGitHubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = User::where('github_id', $githubUser->id)->first();

        if (!$user) {
            $user = new User();
            $user->github_id = $githubUser->id;
            $user->username = $githubUser->name;

            try {
                $user->save();
            } catch (Exception) {
                $user->username = $githubUser->name . '_' . bin2hex(random_bytes(5));
                $user->save();
            }
        }

        Auth::login($user);

        return redirect()->route('home');
    }


    public function handleGoogleCallback() {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = new User();
            $user->google_id = $googleUser->id;
            $user->username = $googleUser->name;

            try {
                $user->save();
            } catch (Exception) {
                $user->username = $googleUser->name . '_' . bin2hex(random_bytes(5));
                $user->save();
            }
        }

        Auth::login($user);

        return redirect()->route('home');
    }


    public function handleGitLabCallback() {
        $gitlabUser = Socialite::driver('gitlab')->user();

        $user = User::where('gitlab_id', $gitlabUser->id)->first();

        if (!$user) {
            $user = new User();
            $user->gitlab_id = $gitlabUser->id;
            $user->username = $gitlabUser->name;

            try {
                $user->save();
            } catch (Exception) {
                $user->username = $gitlabUser->name . '_' . bin2hex(random_bytes(5));
                $user->save();
            }
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}
