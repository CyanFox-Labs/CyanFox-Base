<?php

namespace App\Providers;

use App\Services\Utils\ViewIntegrationService;
use Illuminate\Support\ServiceProvider;
use TallStackUi\Facades\TallStackUi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ViewIntegrationService::class, function () {
            return new ViewIntegrationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TallStackUi::personalize()
            ->dialog()
            ->block('background', 'fixed inset-0 dark:bg-gray-600 bg-gray-400 bg-opacity-75 transition-opacity');
    }
}
