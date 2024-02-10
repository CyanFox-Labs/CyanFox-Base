<?php

namespace App\Providers;

use App\Services\ModuleIntegrationCollector;
use App\Services\SpotlightValueCollector;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
