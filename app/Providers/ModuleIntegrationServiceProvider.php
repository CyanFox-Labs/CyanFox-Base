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
        foreach (app('integrate.views')->getAll() as $moduleComponent) {
            if (!isset($moduleComponent)) {
                continue;
            }

            switch ($moduleComponent['location']) {
                case 'sidebar':
                    $this->addModuleComponentToView($moduleComponent, 'components.navigation.sidebar');
                    break;
                case 'home':
                    $this->addModuleComponentToView($moduleComponent, 'livewire.home');
                    break;
                case 'account.profile':
                    $this->addModuleComponentToView($moduleComponent, 'livewire.account.profile');
                    break;
                case 'admin.sidebar':
                    $this->addModuleComponentToView($moduleComponent, 'components.navigation.admin');
                    break;
                case 'admin.dashboard':
                    $this->addModuleComponentToView($moduleComponent, 'livewire.admin.dashboard');
                    break;
            }
        }
    }

    private function addModuleComponentToView($moduleComponent, $view): void
    {
        view()->composer($view, function ($view) use ($moduleComponent) {
            $view->with('moduleComponent', $moduleComponent);
        });
    }
}
