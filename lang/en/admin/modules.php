<?php

return [
    'tab_title' => 'Admin • Modules',
    'title' => 'Modules',
    'no_modules' => 'No modules found.',
    'enabled' => 'Enabled',
    'disabled' => 'Disabled',

    'tooltip' => [
        'disable_module' => 'Disable Module',
        'enable_module' => 'Enable Module',
        'run_migrations' => 'Run Database Migrations',
    ],

    'notifications' => [
        'module_enabled' => 'Module enabled successfully.',
        'module_disabled' => 'Module disabled successfully.',
        'migrations_ran' => 'Database migrations ran successfully.',
    ],

    'buttons' => [
        'install_module' => 'Install Module',
    ],

    'modals' => [
        'delete_module' => [
            'title' => 'Delete Module',
            'description' => 'Are you sure you want to delete this module?',

            'notifications' => [
                'module_deleted' => 'Module deleted successfully.',
            ],
            'buttons' => [
                'delete_module' => 'Delete Module',
            ],
        ],
        'install_module' => [
            'title' => 'Install Module',
            'description' => 'Select a module to install.',
            'module' => 'Module',

            'notifications' => [
                'module_installed' => 'Module installed successfully.',
            ],
            'buttons' => [
                'install_module' => 'Install Module',
            ],
        ],
    ],
];
