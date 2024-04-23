<?php

use App\Livewire\Installer\Installer;
use Illuminate\Support\Facades\Route;

if (!setting('app_installed') && !config('app.installed')) {
    Route::get('/', Installer::class)->name('install');
}
