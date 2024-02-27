<?php

namespace App\Providers;

use App\Facades\UserManager;
use App\Services\Collectors\ModuleIntegrationCollector;
use App\Services\Collectors\SpotlightValueCollector;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Facades\Pulse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('integrate.views', function () {
            return new ModuleIntegrationCollector;
        });
        $this->app->singleton('spotlight.values', function () {
            return new SpotlightValueCollector;
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Pulse::user(fn ($user) => [
            'name' => $user->name,
            'extra' => $user->email,
            'avatar' => UserManager::getUser($user)->getAvatarURL(),
        ]);
    }
}
