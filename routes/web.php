<?php

use App\Livewire\Account\ForceActivateTwoFactor;
use App\Livewire\Account\ForceChangePassword;
use App\Livewire\Account\Profile;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Home;
use App\Services\Users\OAuthService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (setting('auth_enable')) {
    Route::group(['prefix' => 'auth', 'middleware' => ['language', 'throttle:20,1']], function () {
        Route::get('login', Login::class)->name('auth.login')->middleware('guest');

        if (setting('auth_enable_register')) {
            Route::get('register', Register::class)->name('auth.register')->middleware('guest');
        }

        if (setting('auth_enable_forgot_password')) {
            Route::get('forgot-password', ForgotPassword::class)->name('auth.forgot-password')->middleware('guest');
            Route::get('forgot-password/{resetToken}', ForgotPassword::class)->name('auth.forgot-password')->middleware('guest');
        }

        Route::get('{provider}/redirect', [OAuthService::class, 'redirectToProvider'])->name('auth.redirect');

        if (setting('oauth_enable_github')) {
            Route::get('github/callback', [OAuthService::class, 'handleGitHubCallback'])->name('auth.github.callback');
        }
        if (setting('oauth_enable_discord')) {
            Route::get('discord/callback', [OAuthService::class, 'handleDiscordCallback'])->name('auth.discord.redirect'); // Not tested yet
        }
        if (setting('oauth_enable_google')) {
            Route::get('google/callback', [OAuthService::class, 'handleGoogleCallback'])->name('auth.google.callback'); // Not tested yet
        }

        Route::get('logout', function () {
            auth()->logout();
            return redirect()->route('auth.login');
        })->name('auth.logout')->middleware('auth');
    });

    Route::group(['prefix' => 'account', 'middleware' => ['auth']], function () {
        Route::get('change-password', ForceChangePassword::class)->name('account.force-change.password');
        Route::get('activate-two-factor', ForceActivateTwoFactor::class)->name('account.force-activate.two-factor');
    });
}

Route::group(['middleware' => ['auth', 'disabled', 'force_change']], function () {
    Route::get('/', Home::class)->name('home');

    if (setting('auth_enable')) {
        Route::group(['prefix' => 'account'], function () {
            Route::get('/profile', Profile::class)->name('account.profile');
        });
    }
});

Route::get('errors/{errorCode}', function () {
    if (request()->errorCode < 400 || request()->errorCode > 599) {
        abort(400);
    }

    abort(request()->errorCode);
});
