<?php

return [
    'rate_limit' => 'Maximale Anzahl an Anmeldeversuchen erreicht. Bitte versuchen es in :seconds Sekunden erneut.',
    'user_not_found' => 'Dieser Benutzer wurde nicht gefunden.',
    'buttons' => [
        'back_to_login' => 'Zurück zum Login',
    ],
    'login' => [
        'tab_title' => 'Anmelden',
        'remember_me' => 'Angemeldet bleiben',
        'two_factor_code' => '2-Faktor-Code',
        'recovery_code' => 'Wiederherstellungscode',
        'try_recovery_code' => 'Wiederherstellungscode versuchen.',
        'try_two_factor_code' => '2-Faktor-Code versuchen.',
        'user_disabled' => 'Dieser Benutzer wurde deaktiviert.',

        'buttons' => [
            'login' => 'Anmelden',
            'forgot_password' => 'Passwort vergessen?',
            'register' => 'Registrieren',
        ],

        'login_with' => [
            'github' => '<i class="bi bi-github"></i>',
            'google' => '<i class="bi bi-google"></i>',
            'discord' => '<i class="bi bi-discord"></i>',
        ],
    ],
    'register' => [
        'tab_title' => 'Registrieren',

        'notifications' => [
            'registered' => 'Dein Konto wurde erfolgreich erstellt',
        ],
        'buttons' => [
            'register' => 'Registrieren',
        ],
    ],
    'forgot_password' => [
        'tab_title' => 'Passwort vergessen',

        'notifications' => [
            'reset_link_sent' => 'Ein Link zum Zurücksetzen des Passworts wurde an Deine E-Mail-Adresse gesendet.',
            'reset_link_invalid' => 'Dieser Link zum Zurücksetzen des Passworts ist ungültig.',
            'reset_link_expired' => 'Dieser Link zum Zurücksetzen des Passworts ist abgelaufen.',
            'password_reset' => 'Dein Passwort wurde erfolgreich zurückgesetzt.',
        ],
        'buttons' => [
            'send_reset_link' => 'Link senden',
            'reset_password' => 'Passwort zurücksetzen',
        ],
    ],
];
