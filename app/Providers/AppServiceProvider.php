<?php

namespace App\Providers;

use App\Services\Utils\ViewIntegrationService;
use Illuminate\Contracts\Routing\UrlGenerator;
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
            return new ViewIntegrationService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        TallStackUi::personalize()
            ->card()
            ->block('header.wrapper', 'dark:border-b-dark-600 border-b border-b-gray-100 p-4');

        TallStackUi::personalize()
            ->select('styled')
            ->block('box.list.item.selected', 'font-semibold');

        if (config('settings.force_https')) {
            $url->forceScheme('https');
        }
    }
}
