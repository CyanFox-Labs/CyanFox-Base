<?php

use App\Livewire\Installer\Installer;

if (!setting('app_installed')) {
    Route::get('', Installer::class)->name('installer');
}
