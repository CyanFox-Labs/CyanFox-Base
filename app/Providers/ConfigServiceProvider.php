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
            'services.google.client_id' => setting('oauth_google_client_id'),
            'services.google.client_secret' => setting('oauth_google_client_secret', true),
            'services.google.redirect' => setting('oauth_google_redirect'),
            'services.github.client_id' => setting('oauth_github_client_id'),
            'services.github.client_secret' => setting('oauth_github_client_secret', true),
            'services.github.redirect' => setting('oauth_github_redirect'),
            'services.discord.client_id' => setting('oauth_discord_client_id'),
            'services.discord.client_secret' => setting('oauth_discord_client_secret', true),
            'services.discord.redirect' => setting('oauth_discord_redirect'),

            'app.name' => setting('app_name'),
            'app.url' => setting('app_url'),
            'app.timezone' => setting('app_timezone'),
            'app.locale' => setting('app_lang'),

        ];

        if (!config('app.dont_use_database') || config('app.env') != 'testing') {
            foreach ($configValues as $key => $value) {
                Config::set($key, $value);
            }
        }
    }
}
