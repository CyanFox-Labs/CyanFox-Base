<?php

use App\Livewire\Account\ForgotPassword;
use App\Livewire\Admin\Admin;
use App\Livewire\Admin\Groups\GroupList;
use App\Livewire\Admin\Users\UserCreate;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
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
        Route::get('/account/change-password');
        Route::get('/', Home::class)->name('home');
        Route::get('/profile', Profile::class)->name('profile');

        Route::group(['prefix' => 'admin', 'middleware' => ['role:Super Admin']], function () {
            Route::get('/', Admin::class)->name('admin');

            Route::group(['prefix' => '/users'], function () {
                Route::get('/', UserList::class)->name('admin-user-list');
                Route::get('/create', UserCreate::class)->name('admin-user-create');
                Route::get('/edit/{userId}', UserEdit::class)->name('admin-user-edit');

            });
            Route::group(['prefix' => '/roles'], function () {
                Route::get('/', GroupList::class)->name('admin-role-list');
            });
        });

        Route::get('/logout', function () {
            auth()->logout();
            return redirect()->route('login');
        })->name('logout');
    });


    Route::middleware(['web', 'throttle:30,1'])->group(function () {
        Route::get('/login', Login::class)->name('login');

        if (env('ENABLE_REGISTRATION')) {
            Route::get('/register', Register::class)->name('register');
        }

        if (env('ENABLE_FORGOT_PASSWORD')) {
            Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
            Route::get('/forgot-password/{resetToken}', ForgotPassword::class)->name('forgot-password');
        }
    });

});
