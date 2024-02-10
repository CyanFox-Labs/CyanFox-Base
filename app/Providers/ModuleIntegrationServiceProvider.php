<?php

namespace App\Providers;

use App\Services\ModuleIntegrationCollector;
use Illuminate\Support\ServiceProvider;

class ModuleIntegrationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('integrate.views', function () {
            return new ModuleIntegrationCollector();
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
