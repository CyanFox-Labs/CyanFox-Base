<?php

return [
    'tab_title' => 'Installation',
    'tabs' => [
        'database' => 'Datenbank',
        'system' => 'System',
        'email' => 'E-Mail',
        'create_user' => 'Benutzer erstellen',
    ],

    'buttons' => [
        'next' => 'Nächster Schritt',
        'back' => 'Zurück',
        'finish' => 'Fertig',
    ],

    'database' => [
        'host' => 'Host',
        'port' => 'Port',
        'database' => 'Datenbank',
        'username' => 'Benutzername',
        'password' => 'Passwort',

        'alerts' => [
            'success' => [
                'title' => 'Datenbankverbindung erfolgreich',
                'message' => 'Die Datenbankverbindung wurde erfolgreich hergestellt.',
            ],
            'error' => [
                'title' => 'Datenbankverbindung fehlgeschlagen',
            ],
        ],

        'buttons' => [
            'test_connection' => 'Verbindung testen',
        ]
    ],

    'system' => [
        'app_name' => 'App Name',
        'app_url' => 'App URL',
        'app_lang' => 'App Sprache',
        'app_timezone' => 'App Zeitzone',
        'unsplash_utm' => 'Unsplash UTM',
        'unsplash_api_key' => 'Unsplash API Key',
        'project_version_url' => 'Projekt Version URL',
        'template_version_url' => 'Template Version URL',
        'icon_url' => 'Icon URL',
    ],

    'email' => [
        'tabs' => [
            'welcome' => 'Willkommen',
            'login' => 'Login',
            'forgot_password' => 'Passwort vergessen',
        ],

        'welcome' => [
            'welcome_title' => 'Willkommen Titel',
            'welcome_subject' => 'Willkommen Betreff',
            'welcome_content' => 'Willkommen Inhalt',
            'welcome_placeholders_hint' => 'Du kannst folgende Variablen nutzen: {username}, {firstName}, {lastName}, {password}, {loginLink}, {appName}',
        ],

        'login' => [
            'enable_login' => 'Login E-Mail aktivieren',
            'login_title' => 'Login Titel',
            'login_subject' => 'Login Betreff',
            'login_content' => 'Login Inhalt',
            'login_placeholders_hint' => 'Du kannst folgende Variablen nutzen: {username}, {firstName}, {lastName}, {ipAddress}, {userAgent}',
        ],

        'forgot_password' => [
            'forgot_password_title' => 'Passwort vergessen Titel',
            'forgot_password_subject' => 'Passwort vergessen Betreff',
            'forgot_password_content' => 'Passwort vergessen Inhalt',
            'forgot_password_placeholders_hint' => 'Du kannst folgende Variablen nutzen: {username}, {firstName}, {lastName}',
        ],
    ],
];
