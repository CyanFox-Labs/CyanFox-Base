<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class SpotlightServiceProvider extends ServiceProvider
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
        app('spotlight.values')->add([
            [
                'name' => __('navigation/spotlight.default.profile.title'),
                'description' => __('navigation/spotlight.default.profile.description'),
                'route' => 'account.profile',
                'icon' => Blade::render('<i class="icon-user text-3xl"></i>'),
                'admin' => false,
            ],
            [
                'name' => __('navigation/spotlight.default.logout.title'),
                'description' => __('navigation/spotlight.default.logout.description'),
                'route' => 'auth.logout',
                'icon' => Blade::render('<i class="icon-log-out text-3xl"></i>'),
                'admin' => false,
            ]
        ]);


        /* Admin */
        app('spotlight.values')->add([
            [
                'name' => __('navigation/spotlight.admin.modules.title'),
                'description' => __('navigation/spotlight.admin.modules.description'),
                'route' => 'admin.modules',
                'icon' => Blade::render('<i class="icon-blocks text-3xl"></i>'),
                'admin' => false,
            ],
            [
                'name' => __('navigation/spotlight.admin.settings.title'),
                'description' => __('navigation/spotlight.admin.settings.description'),
                'route' => 'admin.settings',
                'icon' => Blade::render('<i class="icon-settings-2 text-3xl"></i>'),
                'admin' => false,
            ],
            [
                'name' => __('navigation/spotlight.admin.activity.title'),
                'description' => __('navigation/spotlight.admin.activity.description'),
                'route' => 'admin.activity',
                'icon' => Blade::render('<i class="icon-eye text-3xl"></i>'),
                'admin' => false,
            ]
        ]);

        /* Admin - Users */
        app('spotlight.values')->add([
            [
                'name' => __('navigation/spotlight.admin.users.create.title'),
                'description' => __('navigation/spotlight.admin.users.create.description'),
                'route' => 'admin.users.create',
                'icon' => Blade::render('<i class="icon-user-plus text-3xl"></i>'),
                'admin' => false,
            ],
            [
                'name' => __('navigation/spotlight.admin.users.list.title'),
                'description' => __('navigation/spotlight.admin.users.list.title'),
                'route' => 'admin.users',
                'icon' => Blade::render('<i class="icon-users text-3xl"></i>'),
                'admin' => false,
            ]
        ]);

        /* Admin - Groups */
        app('spotlight.values')->add([
            [
                'name' => __('navigation/spotlight.admin.groups.create.title'),
                'description' => __('navigation/spotlight.admin.groups.create.description'),
                'route' => 'admin.groups.create',
                'icon' => Blade::render('<i class="icon-shield-plus text-3xl"></i>'),
                'admin' => false,
            ],
            [
                'name' => __('navigation/spotlight.admin.groups.list.title'),
                'description' => __('navigation/spotlight.admin.groups.list.description'),
                'route' => 'admin.groups',
                'icon' => Blade::render('<i class="icon-shield text-3xl"></i>'),
                'admin' => false,
            ]
        ]);
    }
}
