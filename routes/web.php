<?php

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

    if(get_setting('auth', 'enable_register')) {
        Route::get('register', Register::class)->name('auth.register')->middleware('guest');
    }

    if(get_setting('auth', 'enable_forgot_password')) {
        Route::get('forgot-password', ForgotPassword::class)->name('auth.forgot-password')->middleware('guest');
        Route::get('forgot-password/{resetToken}', ForgotPassword::class)->name('auth.forgot-password')->middleware('guest');
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
