<?php

return [
    'tab_title' => 'Admin • Module',
    'title' => 'Module',
    'no_modules' => 'Keine Module gefunden.',
    'enabled' => 'Aktiviert',
    'disabled' => 'Deaktiviert',

    'tooltip' => [
        'disable_module' => 'Modul deaktivieren',
        'enable_module' => 'Modul aktivieren',
        'run_migrations' => 'Datenbankmigrationen durchführen',
    ],

    'notifications' => [
        'module_enabled' => 'Modul erfolgreich aktiviert.',
        'module_disabled' => 'Modul erfolgreich deaktiviert.',
        'migrations_ran' => 'Datenbankmigrationen erfolgreich durchgeführt.',
    ],

    'buttons' => [
        'install_module' => 'Modul installieren',
    ],

    'modals' => [
        'delete_module' => [
            'title' => 'Modul löschen',
            'description' => 'Bist du dir sicher, dass du dieses Modul löschen möchtest?',

            'notifications' => [
                'module_deleted' => 'Modul erfolgreich gelöscht.',
            ],
            'buttons' => [
                'delete_module' => 'Modul löschen',
            ],
            'install_module' => [
                'title' => 'Modul installieren',
                'description' => 'Bitte wähle eine zip-Datei aus, um das Modul zu installieren.',
                'module' => 'Modul',

                'notifications' => [
                    'module_installed' => 'Modul erfolgreich installiert',
                ],
                'buttons' => [
                    'install_module' => 'Modul installieren',
                ],
            ],
        ],
    ],
];
