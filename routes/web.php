<?php

use App\Livewire\Auth\Login;
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

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', Login::class)->name('auth.login')->middleware('guest');

    Route::get('logout', function () {
        auth()->logout();
        return redirect()->route('auth.login');
    })->name('auth.logout')->middleware('auth');
});
