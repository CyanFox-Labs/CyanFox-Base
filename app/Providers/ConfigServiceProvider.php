<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $configValues = [
            'app.name' => setting('settings.name'),
            'app.url' => setting('settings.url'),
            'app.timezone' => setting('settings.timezone'),
            'app.locale' => setting('settings.lang'),
            'app.fallback_locale' => setting('settings.fallback_lang'),
        ];

        if (!config('settings.disable_db_settings') && config('app.env') !== 'testing') {
            foreach ($configValues as $key => $value) {
                Config::set($key, $value);
            }
        }
    }
}
