<?php

return [
    'tab_title' => 'Admin • Einstellungen',
    'title' => 'Einstellungen',

    'buttons' => [
        'update_settings' => 'Einstellungen aktualisieren',
        'reset_logo' => 'Logo zurücksetzen',
    ],

    'notifications' => [
        'settings_updated' => 'Einstellungen erfolgreich aktualisiert!',
    ],

    'tabs' => [
        'system' => 'System',
        'auth' => 'Authentifizierung',
        'emails' => 'E-Mails',
        'profile' => 'Profil',
        'security' => 'Sicherheit',
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
        'logo' => 'Logo',
    ],

    'auth' => [
        'enable_auth' => 'Authentifizierung aktivieren',
        'enable_auth_hint' => 'Das Ausschalten der Authentifizierung wird Funktionen wie das Admin-Panel und das Profil blockieren.
         Du kannst es über die Datenbank wieder aktivieren, indem du enable_auth auf 1 in der Einstellungstabelle setzt.',
        'enable_captcha' => 'Captcha aktivieren',
        'enable_forgot_password' => 'Passwort vergessen aktivieren',
        'enable_registration' => 'Registrierung aktivieren',
        'enable_oauth' => 'OAuth aktivieren',
        'enable_local_login' => 'Lokales Login aktivieren',

        'tabs' => [
            'google' => 'Google',
            'github' => 'GitHub',
            'discord' => 'Discord',
        ],

        'google' => [
            'enable_google_oauth' => 'Google OAuth aktivieren',
            'google_client_id' => 'Google Client ID',
            'google_client_secret' => 'Google Client Secret',
            'google_redirect_url' => 'Google Redirect URL',
        ],
        'github' => [
            'enable_github_oauth' => 'GitHub OAuth aktivieren',
            'github_client_id' => 'GitHub Client ID',
            'github_client_secret' => 'GitHub Client Secret',
            'github_redirect_url' => 'GitHub Redirect URL',
        ],
        'discord' => [
            'enable_discord_oauth' => 'Discord OAuth aktivieren',
            'discord_client_id' => 'Discord Client ID',
            'discord_client_secret' => 'Discord Client Secret',
            'discord_redirect_url' => 'Discord Redirect URL',
        ],
    ],

    'emails' => [
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

    'profile' => [
        'default_avatar_url' => 'Standard Avatar URL',
        'default_avatar_url_hint' => 'Du kannst folgende Variablen nutzen: {username}',
        'enable_change_avatar' => 'Avatar ändern aktivieren',
        'enable_delete_account' => 'Account löschen aktivieren',
    ],

    'security' => [
        'password_minimum_length' => 'Passwort Mindestlänge',
        'password_minimum_length_option' => '>= :length Zeichen',
        'password_require_lowercase' => 'Passwort benötigt Kleinbuchstaben',
        'password_require_uppercase' => 'Passwort benötigt Großbuchstaben',
        'password_require_numbers' => 'Passwort benötigt Zahlen',
        'password_require_special_characters' => 'Passwort benötigt Sonderzeichen',
    ],
];
