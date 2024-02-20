<?php

return [
    'tabs' => [
        'overview' => 'Overview',
        'sessions' => 'Sessions',
        'api_keys' => 'API Keys',
        'activity' => 'Activity',
    ],

    'language_and_theme' => [
        'title' => 'Language & Theme',
        'select_language' => 'Select Language',
        'select_theme' => 'Select Theme',

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
            'cyanfox_light' => 'CyanFox Light'
        ],
    ],

    'actions' => [
        'title' => 'Actions',

        'buttons' => [
            'delete_account' => 'Delete Account',
            'activate_two_factor' => 'Activate Two-Factor Authentication',
            'disable_two_factor' => 'Disable Two-Factor Authentication',
            'show_recovery_codes' => 'Show Recovery Codes',
            'setup_password' => 'Setup Password',
        ]
    ],

    'account_details' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'username' => 'Username',
        'email' => 'Email',

        'current_password' => 'Current Password',
        'new_password' => 'New Password',
        'confirm_new_password' => 'Confirm New Password',
    ],

    'notifications' => [
        'language_and_theme_updated' => 'Language and theme updated successfully!',
        'profile_informations_updated' => 'Profile informations updated successfully!',
        'password_updated' => 'Password updated successfully!',
        'session_logged_out' => 'Session logged out successfully!',
    ],

    'sessions' => [
        'title' => 'Sessions',
        'table' => [
            'ip_address' => 'IP Address',
            'user_agent' => 'User Agent',
            'device' => 'Device',
            'last_activity' => 'Last Activity',
        ],
        'device_types' => [
            'desktop' => 'Desktop',
            'phone' => 'Phone',
            'tablet' => 'Tablet',
            'unknown' => 'Unknown',
        ],
        'current_session' => 'Current Session',

        'buttons' => [
            'logout_other_devices' => 'Logout Other Devices',
        ],
    ],

    'api_keys' => [
        'title' => 'API Keys',
        'table' => [
            'name' => 'Name',
            'last_used_at' => 'Last Used At',
        ],

        'buttons' => [
            'create_api_key' => 'Create API Key',
            'api_docs' => 'API Docs',
        ],
    ],

    'activity' => [
        'title' => 'Activity',
        'table' => [
            'log_name' => 'Log Name',
            'log_message' => 'Log Message',
            'subject' => 'Subject',
            'causer' => 'Causer',
            'ip_address' => 'IP Address',
        ],
    ]
];
