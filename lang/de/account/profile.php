<?php

return [
    'tab_title' => 'Profil',
    'tabs' => [
        'overview' => 'Übersicht',
        'sessions' => 'Sitzungen',
        'api_keys' => 'API Schlüssel',
        'activity' => 'Aktivitäten',
    ],

    'buttons' => [
        'update_profile' => 'Profil aktualisieren',
    ],

    'modals' => [
        'create_api_key' => [
            'created' => [
                'title' => 'API Schlüssel erstellt',
                'description' => 'Dein neuer API Schlüssel wurde erfolgreich erstellt. Bitte kopiere ihn jetzt. Du wirst ihn nicht mehr sehen können.',
            ],
            'title' => 'API Schlüssel erstellen',
            'description' => 'Bitte gib einen Namen für deinen neuen API Schlüssel ein.',
            'api_key_name' => 'API Schlüssel Name',

            'notifications' => [
                'api_key_created' => 'API Schlüssel erfolgreich erstellt.',
            ],
            'buttons' => [
                'create_api_key' => 'API Schlüssel erstellen',
            ],
        ],
        'delete_api_key' => [
            'title' => 'API Schlüssel löschen',
            'description' => 'Bist du sicher, dass du diesen API Schlüssel löschen möchtest?',

            'notifications' => [
                'api_key_deleted' => 'API Schlüssel erfolgreich gelöscht.',
            ],
            'buttons' => [
                'delete_api_key' => 'API Schlüssel löschen',
            ],
        ],
        'activate_two_factor' => [

            'notifications' => [
                'two_factor_activated' => '2 Faktor Authentifizierung erfolgreich aktiviert.',
            ],
            'buttons' => [
                'activate_two_factor' => '2 Faktor Authentifizierung aktivieren',
            ],
        ],
        'disable_two_factor' => [
            'title' => '2 Faktor Authentifizierung deaktivieren',
            'description' => 'Bitte gebe dein Passwort ein, um die 2 Faktor Authentifizierung zu deaktivieren.',

            'notifications' => [
                'two_factor_disabled' => '2 Faktor Authentifizierung erfolgreich deaktiviert.',
            ],
            'buttons' => [
                'disable_two_factor' => '2 Faktor Authentifizierung deaktivieren',
            ],
        ],
        'show_recovery_codes' => [
            'auth' => [
                'title' => '2 Faktor Wiederherstellungs Codes',
                'description' => 'Bitte bestätige dein Passwort, um die Wiederherstellungs Codes anzuzeigen.',
                'buttons' => [
                    'show_recovery_codes' => '2 Faktor Wiederherstellungs Codes anzeigen',
                ],
            ],
            'title' => '2 Faktor Wiederherstellungs Codes',
            'description' => 'Bitte speichere diese Wiederherstellungs Codes an einem sicheren Ort. Sie können verwendet werden, um auf dein Konto zuzugreifen, wenn du keinen Zugriff auf dein 2 Faktor Gerät hast.',
            'buttons' => [
                'regenerate_recovery_codes' => 'Codes neu generieren',
                'download_recovery_codes' => 'Codes herunterladen',
            ],
        ],
        'delete_account' => [
            'title' => 'Konto löschen',
            'description' => 'Bist du sicher, dass du dein Konto <b>PERMANENT</b> löschen möchtest?',

            'notifications' => [
                'account_deleted' => 'Konto erfolgreich gelöscht.',
            ],
            'buttons' => [
                'delete_account' => 'Konto löschen',
            ],
        ],
        'change_avatar' => [
            'title' => 'Avatar ändern',
            'description' => 'Bitte wähle ein Bild oder gib eine URL ein, um deinen Avatar zu ändern.',
            'custom_avatar_url' => 'Benutzerdefinierte Avatar URL',

            'notifications' => [
                'avatar_updated' => 'Avatar erfolgreich aktualisiert.',
                'avatar_reset' => 'Avatar erfolgreich zurückgesetzt.',
            ],
            'buttons' => [
                'reset_avatar' => 'Avatar zurücksetzen',
                'save_avatar' => 'Avatar speichern',
            ],
        ],
        'setup_password' => [
            'title' => 'Passwort einrichten',
            'description' => 'Bitte gebe ein neues Passwort ein, um dein Konto zu sichern.',

            'notifications' => [
                'password_setup' => 'Passwort erfolgreich eingerichtet.',
            ],
            'buttons' => [
                'setup_password' => 'Passwort einrichten',
            ],
        ],
        'logout_other_devices' => [
            'title' => 'Andere Geräte abmelden',
            'description' => 'Bitte gebe dein Passwort ein, um alle anderen Geräte abzumelden.',

            'notifications' => [
                'other_devices_logged_out' => 'Andere Geräte erfolgreich abgemeldet.',
            ],
            'buttons' => [
                'logout_other_devices' => 'Andere Geräte abmelden',
            ],
        ],
    ],

    'overview' => [
        'notifications' => [
            'profile_informations_updated' => 'Profilinformationen erfolgreich aktualisiert.',
            'password_updated' => 'Passwort erfolgreich aktualisiert.',
        ],
    ],

    'language_and_theme' => [
        'title' => 'Sprache und Erscheinungsbild',
        'select_language' => 'Sprache auswählen',
        'select_theme' => 'Erscheinungsbild auswählen',

        'notifications' => [
            'language_and_theme_updated' => 'Sprache und Erscheinungsbild erfolgreich aktualisiert.',
        ],

        'themes' => [
            'light' => 'Light',
            'dark' => 'Dark',
            'cupcake' => 'Cupcake',
            'bumblebee' => 'Bumblebee',
            'emerald' => 'Emerald',
            'corporate' => 'Corporate',
            'synthwave' => 'Synthwave',
            'retro' => 'Retro',
            'valentine' => 'Valentine',
            'halloween' => 'Halloween',
            'garden' => 'Garden',
            'forest' => 'Forest',
            'lofi' => 'Lo-Fi',
            'pastel' => 'Pastel',
            'fantasy' => 'Fantasy',
            'wireframe' => 'Wireframe',
            'black' => 'Black',
            'luxury' => 'Luxury',
            'dracula' => 'Dracula',
            'cmyk' => 'CMYK',
            'autumn' => 'Autumn',
            'business' => 'Business',
            'acid' => 'Acid',
            'lemonade' => 'Lemonade',
            'night' => 'Night',
            'coffee' => 'Coffee',
            'dim' => 'Dim',
            'winter' => 'Winter',
            'nord' => 'Nord',
            'sunset' => 'Sunset',
            'catppuccin_latte' => 'Catppuccin Latte',
            'catppuccin_frappee' => 'Catppuccin Frappee',
            'catppuccin_macchiato' => 'Catppuccin Macchiato',
            'catppuccin_mocha' => 'Catppuccin Mocha',
            'cyanfox_dark' => 'CyanFox Dark',
            'cyanfox_light' => 'CyanFox Light',
        ],
    ],

    'actions' => [
        'title' => 'Aktionen',
        'buttons' => [
            'show_recovery_codes' => 'Wiederherstellungs Codes anzeigen',
            'disable_two_factor' => '2 Faktor deaktivieren',
            'activate_two_factor' => '2 Faktor aktivieren',
            'delete_account' => 'Konto löschen',
            'setup_password' => 'Passwort einrichten',
        ],
    ],

    'sessions' => [
        'title' => 'Sitzungen',
        'current_session' => 'Aktuelle Sitzung',

        'notifications' => [
            'session_logged_out' => 'Sitzung erfolgreich abgemeldet.',
        ],
        'buttons' => [
            'logout_other_devices' => 'Andere Geräte abmelden',
        ],
        'table' => [
            'ip_address' => 'IP Adresse',
            'user_agent' => 'User Agent',
            'device' => 'Gerät',
            'last_activity' => 'Letzte Aktivität',
        ],
        'device_types' => [
            'desktop' => 'Desktop',
            'phone' => 'Smartphone',
            'tablet' => 'Tablet',
            'unknown' => 'Unbekannt',
        ],
    ],

    'api_keys' => [
        'title' => 'API Schlüssel',
        'buttons' => [
            'create_api_key' => 'API Schlüssel erstellen',
            'api_docs' => 'API Dokumentation',
        ],
        'table' => [
            'name' => 'Name',
            'last_used' => 'Zuletzt verwendet',
        ],
    ],

    'activity' => [
        'title' => 'Aktivitäten',
        'table' => [
            'log_name' => 'Log Name',
            'description' => 'Beschreibung',
            'subject' => 'Subjekt',
            'causer' => 'Verursacher',
            'ip_address' => 'IP Adresse',
        ],
    ],
];
