<?php

return [
    'permissions' => 'Berechtigungen',
    'groups' => 'Gruppen',
    'force_activate_two_factor' => 'Muss 2 Faktor aktivieren',
    'force_change_password' => 'Muss Passwort ändern',
    'disabled' => 'Deaktiviert',

    'modals' => [
        'delete_user' => [
            'title' => 'Benutzer löschen',
            'description' => 'Bist du dir sicher, dass du diesen Benutzer löschen möchtest?',

            'notifications' => [
                'user_deleted' => 'Benutzer erfolgreich gelöscht!',
            ],
            'buttons' => [
                'delete_user' => 'Benutzer löschen',
            ],
        ],
    ],

    'list' => [
        'tab_title' => 'Admin • Benutzer',
        'title' => 'Benutzer',
        'buttons' => [
            'create_user' => 'Benutzer erstellen',
        ],
        'table' => [
            'avatar' => 'Avatar',
            'two_factor_enabled' => '2 Faktor aktiviert',
            'force_change_password' => 'Passwort ändern erzwingen',
            'force_activate_two_factor' => '2 Faktor aktivieren erzwingen',
            'disabled' => 'Deaktiviert',
        ],
    ],
    'create' => [
        'tab_title' => 'Admin • Benutzer » Benutzer erstellen',
        'title' => 'Benutzer erstellen',
        'send_welcome_email' => 'Willkommens-E-Mail senden',

        'notifications' => [
            'user_created' => 'Benutzer erfolgreich erstellt!',
        ],
        'buttons' => [
            'create_user' => 'Benutzer erstellen',
        ],
    ],
    'update' => [
        'tab_title' => 'Admin • Benutzer » :user aktualisieren',
        'title' => 'Benutzer aktualisieren',

        'notifications' => [
            'user_updated' => 'Benutzer erfolgreich aktualisiert!',
        ],
        'buttons' => [
            'update_user' => 'Benutzer aktualisieren',
        ],
    ],
];
