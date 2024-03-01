<?php

return [
    'name' => 'Name',
    'guard_name' => 'Guard Name',
    'permissions' => 'Berechtigungen',

    'modals' => [
        'delete_group' => [
            'title' => 'Gruppe löschen',
            'description' => 'Bist du dir sicher, dass du diese Gruppe löschen möchtest?',

            'notifications' => [
                'group_deleted' => 'Gruppe erfolgreich gelöscht.',
            ],
            'buttons' => [
                'delete_group' => 'Gruppe löschen',
            ],
        ],
    ],

    'list' => [
        'tab_title' => 'Admin • Gruppen',
        'title' => 'Gruppen',
        'buttons' => [
            'create_group' => 'Gruppe erstellen',
        ],
        'table' => [
            'name' => 'Name',
            'guard_name' => 'Guard Name',
        ],
    ],

    'create' => [
        'tab_title' => 'Admin • Gruppen » Gruppen erstellen',
        'title' => 'Gruppe erstellen',

        'notifications' => [
            'group_created' => 'Gruppe erfolgreich erstellt.',
        ],
        'buttons' => [
            'create_group' => 'Gruppe erstellen',
        ],
    ],

    'update' => [
        'tab_title' => 'Admin • Gruppen » :group aktualisieren',
        'title' => 'Gruppe aktualisieren',

        'notifications' => [
            'group_updated' => 'Gruppe erfolgreich aktualisiert.',
        ],
        'buttons' => [
            'update_group' => 'Gruppe aktualisieren',
        ],
    ],
];
