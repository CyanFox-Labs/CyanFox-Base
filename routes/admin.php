<?php

use App\Livewire\Admin\Activity\Activity;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Groups\CreateGroup;
use App\Livewire\Admin\Groups\Groups;
use App\Livewire\Admin\Groups\UpdateGroup;
use App\Livewire\Admin\Modules\Modules;
use App\Livewire\Admin\Notifications\CreateNotification;
use App\Livewire\Admin\Notifications\Notifications;
use App\Livewire\Admin\Notifications\UpdateNotification;
use App\Livewire\Admin\Settings\Settings;
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

    Route::group(['prefix' => 'notifications'], function () {
        Route::get('/', Notifications::class)->name('admin.notifications');
        Route::get('/create', CreateNotification::class)->name('admin.notifications.create');
        Route::get('/update/{notificationId}', UpdateNotification::class)->name('admin.notifications.update');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', Users::class)->name('admin.users');
        Route::get('/create', CreateUser::class)->name('admin.users.create');
        Route::get('/update/{userId}', UpdateUser::class)->name('admin.users.update');
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::get('/', Groups::class)->name('admin.groups');
        Route::get('/create', CreateGroup::class)->name('admin.groups.create');
        Route::get('/update/{groupId}', UpdateGroup::class)->name('admin.groups.update');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', Settings::class)->name('admin.settings');
    });

    Route::group(['prefix' => 'modules'], function () {
        Route::get('/', Modules::class)->name('admin.modules');
    });

    Route::group(['prefix' => 'activity'], function () {
        Route::get('/', Activity::class)->name('admin.activity');
    });
});

