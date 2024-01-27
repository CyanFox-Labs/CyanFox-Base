<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\CreateUser;
use App\Livewire\Admin\Users\UpdateUser;
use App\Livewire\Admin\Users\Users;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| These routes are only accessible by users with the "Super Admin" role.
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['role:Super Admin', 'auth', 'disabled']], function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', Users::class)->name('admin.users');
        Route::get('/create', CreateUser::class)->name('admin.users.create');
        Route::get('/update/{userId}', UpdateUser::class)->name('admin.users.update');
    });
});

