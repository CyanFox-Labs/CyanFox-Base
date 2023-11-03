<?php

return [
    'disable_two_factor' => [
        'title' => '2 Faktor deaktivieren',
        'description' => 'Bist du sicher, dass du 2 Faktor deaktivieren möchtest?',
    ],
    'logout' => [
        'title' => 'Abmelden',
        'description' => 'Du hast deine eigene Sitzung angeklickt - möchtest du dich wirklich abmelden?',
    ],

    'revoke_all_sessions' => [
        'title' => 'Alle Sitzungen widerrufen',
        'description' => 'Bist du sicher, dass du alle Sitzungen widerrufen möchtest?',
        'buttons' => [
            'revoke_all_sessions' => 'Alle Sitzungen widerrufen',
        ]
    ],

    'revoke_session' => [
        'title' => 'Sitzung widerrufen',
        'description' => 'Bist du sicher, dass du diese Sitzung widerrufen möchtest?',
        'buttons' => [
            'revoke_session' => 'Sitzung widerrufen',
        ]
    ],

    'recovery_codes' => [
        'password' => [
            'title' => 'Wiederherstellungscodes anzeigen',
            'description' => 'Bitte bestätige dein Passwort, bevor du die Wiederherstellungscodes anzeigen kannst.',
            'buttons' => [
                'show_recovery_codes' => 'Wiederherstellungscodes anzeigen',
            ]
        ],
        'title' => 'Wiederherstellungscodes',
        'description' => 'Speichere diese Wiederherstellungscodes an einem sicheren Ort. Sie können verwendet werden, um den Zugriff auf dein Konto wiederherzustellen, wenn du keinen Zugriff auf dein 2 Faktor Gerät hast.',
        'buttons' => [
            'regenerate' => 'Neu generieren',
        ]
    ]
];
