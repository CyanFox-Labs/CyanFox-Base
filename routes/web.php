<?php

use App\Http\Controllers\OAuthController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
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

Route::group(['prefix' => 'auth', 'middleware' => 'language'], function () {
    Route::get('login', Login::class)->name('auth.login')->middleware('guest');

    if (setting('auth_enable_register')) {
        Route::get('register', Register::class)->name('auth.register')->middleware('guest');
    }

    if (setting('auth_enable_forgot_password')) {
        Route::get('forgot-password', ForgotPassword::class)->name('auth.forgot-password')->middleware('guest');
        Route::get('forgot-password/{resetToken}', ForgotPassword::class)->name('auth.forgot-password')->middleware('guest');
    }

    Route::get('{provider}/redirect', [OAuthController::class, 'redirectToProvider'])->name('auth.redirect');

    if (setting('oauth_enable_github')) {
        Route::get('github/callback', [OAuthController::class, 'handleGitHubCallback'])->name('auth.github.callback');
    }
    if (setting('oauth_enable_gitlab')) {
        Route::get('gitlab/redirect', [OAuthController::class, 'handleGitLabCallback'])->name('auth.gitlab.redirect'); // Not tested yet
    }
    if (setting('oauth_enable_google')) {
        Route::get('google/callback', [OAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback'); // Not tested yet
    }

    Route::get('logout', function () {
        auth()->logout();
        return redirect()->route('auth.login');
    })->name('auth.logout')->middleware('auth');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return response("Hello World!");
    })->name('home');
});
