<?php

namespace App\Providers;

use App\Services\Collectors\ModuleIntegrationCollector;
use App\Services\Collectors\SpotlightValueCollector;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('integrate.views', function () {
            return new ModuleIntegrationCollector();
        });
        $this->app->singleton('spotlight.values', function () {
            return new SpotlightValueCollector();
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
