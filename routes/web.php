<?php

use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Profile;
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

Route::middleware(['setLanguage'])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', Home::class)->name('home');
        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/admin', function () {})->name('admin');
    });


    Route::middleware('web', 'throttle:100,1')->group(function () {
        Route::get('/login', Login::class)->name('login');


        Route::get('/logout', function () {
            auth()->logout();
            return redirect()->route('login');
        })->name('logout');
    });

});
