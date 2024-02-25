<?php

return [
    'enable_auth' => 'Enable Authentication',
    'enable_auth_hint' => 'Turning off authentication will block features such as the admin panel and profile. You can reactivate it via the database by setting enable_auth to 1 in the settings table.',
    'enable_forgot_password' => 'Enable Forgot Password',
    'enable_registration' => 'Enable Registration',
    'enable_oauth' => 'Enable OAuth',
    'enable_local_login' => 'Enable Local Login',
    'enable_captcha' => 'Enable Captcha',

    'oauth' => [
        'google' => [
            'enable_google_oauth' => 'Enable Google OAuth',
            'google_client_id' => 'Google Client ID',
            'google_client_secret' => 'Google Client Secret',
            'google_redirect_url' => 'Google Redirect URL',
        ],
        'github' => [
            'enable_github_oauth' => 'Enable Github OAuth',
            'github_client_id' => 'Github Client ID',
            'github_client_secret' => 'Github Client Secret',
            'github_redirect_url' => 'Github Redirect URL',
        ],
        'discord' => [
            'enable_discord_oauth' => 'Enable Discord OAuth',
            'discord_client_id' => 'Discord Client ID',
            'discord_client_secret' => 'Discord Client Secret',
            'discord_redirect_url' => 'Discord Redirect URL',
        ],
    ],

    'tabs' => [
        'google' => 'Google',
        'github' => 'Github',
        'discord' => 'Discord',
    ],
];
