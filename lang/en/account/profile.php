<?php

return [
    'tab_title' => 'Profile',
    'tabs' => [
        'overview' => 'Overview',
        'sessions' => 'Sessions',
        'api_keys' => 'API Keys',
        'activity' => 'Activity',
    ],

    'buttons' => [
        'update_profile' => 'Update Profile',
    ],

    'modals' => [
        'create_api_key' => [
            'created' => [
                'title' => 'API Key Created',
                'description' => 'Your new API key has been created successfully. Please copy it now, you won\'t be able to see it again.',
            ],
            'title' => 'Create API Key',
            'description' => 'Create a new API key to access the API.',
            'api_key_name' => 'API Key Name',

            'notifications' => [
                'api_key_created' => 'API key created successfully.',
            ],
            'buttons' => [
                'create_api_key' => 'Create API Key',
            ],
        ],
        'delete_api_key' => [
            'title' => 'Delete API Key',
            'description' => 'Are you sure you want to delete this API key? This action cannot be undone.',

            'notifications' => [
                'api_key_deleted' => 'API key deleted successfully.',
            ],
            'buttons' => [
                'delete_api_key' => 'Delete API Key',
            ],
        ],
        'activate_two_factor' => [

            'notifications' => [
                'two_factor_activated' => 'Two factor authentication activated successfully.',
            ],
            'buttons' => [
                'activate_two_factor' => 'Activate Two Factor',
            ],
        ],
        'disable_two_factor' => [
            'title' => 'Disable Two Factor',
            'description' => 'Please enter your password to disable two factor authentication.',

            'notifications' => [
                'two_factor_disabled' => 'Two factor authentication disabled successfully.',
            ],
            'buttons' => [
                'disable_two_factor' => 'Disable Two Factor',
            ],
        ],
        'show_recovery_codes' => [
            'auth' => [
                'title' => 'Two Factor Recovery Codes',
                'description' => 'Please enter your password to view your recovery codes.',
                'buttons' => [
                    'show_recovery_codes' => 'Show Recovery Codes',
                ],
            ],
            'title' => 'Two Factor Recovery Codes',
            'description' => 'Please store these recovery codes in a secure password manager. They can be used to recover access to your account if you lose access to your two factor device.',
            'buttons' => [
                'regenerate_recovery_codes' => 'Regenerate Codes',
                'download_recovery_codes' => 'Download Codes',
            ],
        ],
        'delete_account' => [
            'title' => 'Delete Account',
            'description' => 'Are you sure you want to <b>PERMANENTLY</b> delete your account? This action cannot be undone.',

            'notifications' => [
                'account_deleted' => 'Account deleted successfully.',
            ],
            'buttons' => [
                'delete_account' => 'Delete Account',
            ],
        ],
        'change_avatar' => [
            'title' => 'Change Avatar',
            'description' => 'Please select a new avatar to upload or use a custom avatar URL.',
            'custom_avatar_url' => 'Custom Avatar URL',

            'notifications' => [
                'avatar_updated' => 'Avatar updated successfully.',
                'avatar_reset' => 'Avatar reset successfully.',
            ],
            'buttons' => [
                'reset_avatar' => 'Reset Avatar',
                'save_avatar' => 'Save Avatar',
            ],
        ],
        'setup_password' => [
            'title' => 'Setup Password',
            'description' => 'Please enter a password to secure your account.',

            'notifications' => [
                'password_setup' => 'Password setup successfully.',
            ],
            'buttons' => [
                'setup_password' => 'Setup Password',
            ],
        ],
        'logout_other_devices' => [
            'title' => 'Logout Other Devices',
            'description' => 'Please enter your password to logout of your other devices.',

            'notifications' => [
                'other_devices_logged_out' => 'Other devices logged out successfully.',
            ],
            'buttons' => [
                'logout_other_devices' => 'Logout Other Devices',
            ],
        ],
    ],

    'overview' => [
        'notifications' => [
            'profile_informations_updated' => 'Profile informations updated successfully.',
            'password_updated' => 'Password updated successfully.',
        ],
    ],

    'language_and_theme' => [
        'title' => 'Language & Theme',
        'select_language' => 'Select Language',
        'select_theme' => 'Select Theme',

        'notifications' => [
            'language_and_theme_updated' => 'Language and theme updated successfully.',
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
        'title' => 'Actions',
        'buttons' => [
            'show_recovery_codes' => 'Show Recovery Codes',
            'disable_two_factor' => 'Disable Two Factor',
            'activate_two_factor' => 'Activate Two Factor',
            'delete_account' => 'Delete Account',
            'setup_password' => 'Setup Password',
        ],
    ],

    'sessions' => [
        'title' => 'Sessions',
        'current_session' => 'Current Session',

        'notifications' => [
            'session_logged_out' => 'Session logged out successfully.',
        ],
        'buttons' => [
            'logout_other_devices' => 'Logout Other Devices',
        ],
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
    ],

    'api_keys' => [
        'title' => 'API Keys',
        'buttons' => [
            'create_api_key' => 'Create API Key',
            'api_docs' => 'API Docs',
        ],
        'table' => [
            'name' => 'Name',
            'last_used' => 'Last Used',
        ],
    ],

    'activity' => [
        'title' => 'Activity',
        'table' => [
            'log_name' => 'Log Name',
            'description' => 'Description',
            'subject' => 'Subject',
            'causer' => 'Causer',
            'ip_address' => 'IP Address',
        ],
    ],
];
