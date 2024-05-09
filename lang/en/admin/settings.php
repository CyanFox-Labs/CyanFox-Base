<?php

return [
    'tab_title' => 'Admin • Settings',
    'title' => 'Settings',

    'buttons' => [
        'update_settings' => 'Update Settings',
        'reset_logo' => 'Reset Logo',
    ],

    'notifications' => [
        'settings_updated' => 'Settings updated successfully.',
    ],

    'tabs' => [
        'system' => 'System',
        'auth' => 'Auth',
        'emails' => 'Emails',
        'profile' => 'Profile',
        'security' => 'Security',
    ],

    'system' => [
        'app_name' => 'App Name',
        'app_url' => 'App URL',
        'app_lang' => 'App Language',
        'app_timezone' => 'App Timezone',
        'unsplash_utm' => 'Unsplash UTM',
        'unsplash_api_key' => 'Unsplash API Key',
        'project_version_url' => 'Project Version URL',
        'template_version_url' => 'Template Version URL',
        'icon_url' => 'Icon URL',
        'logo' => 'Logo',
    ],

    'auth' => [
        'enable_auth' => 'Enable Authentication',
        'enable_auth_hint' => 'Turning off authentication will block features such as the admin panel and profile.
         You can reactivate it via the database by setting enable_auth to 1 in the settings table.',
        'enable_captcha' => 'Enable Captcha',
        'enable_forgot_password' => 'Enable Forgot Password',
        'enable_registration' => 'Enable Registration',
        'enable_oauth' => 'Enable OAuth',
        'enable_local_login' => 'Enable Local Login',

        'tabs' => [
            'google' => 'Google',
            'github' => 'GitHub',
            'discord' => 'Discord',
        ],

        'google' => [
            'enable_google_oauth' => 'Enable Google OAuth',
            'google_client_id' => 'Google Client ID',
            'google_client_secret' => 'Google Client Secret',
            'google_redirect_url' => 'Google Redirect URL',
        ],
        'github' => [
            'enable_github_oauth' => 'Enable GitHub OAuth',
            'github_client_id' => 'GitHub Client ID',
            'github_client_secret' => 'GitHub Client Secret',
            'github_redirect_url' => 'GitHub Redirect URL',
        ],
        'discord' => [
            'enable_discord_oauth' => 'Enable Discord OAuth',
            'discord_client_id' => 'Discord Client ID',
            'discord_client_secret' => 'Discord Client Secret',
            'discord_redirect_url' => 'Discord Redirect URL',
        ],
    ],

    'emails' => [
        'tabs' => [
            'welcome' => 'Welcome',
            'login' => 'Login',
            'forgot_password' => 'Forgot Password',
        ],

        'welcome' => [
            'welcome_title' => 'Welcome Title',
            'welcome_subject' => 'Welcome Subject',
            'welcome_content' => 'Welcome Content',
            'welcome_placeholders_hint' => 'You can use the following variables: {username}, {firstName}, {lastName}, {password}, {loginLink}, {appName}',
        ],

        'login' => [
            'enable_login' => 'Enable Login Email',
            'login_title' => 'Login Title',
            'login_subject' => 'Login Subject',
            'login_content' => 'Login Content',
            'login_placeholders_hint' => 'You can use the following variables: {username}, {firstName}, {lastName}, {ipAddress}, {userAgent}',
        ],

        'forgot_password' => [
            'forgot_password_title' => 'Forgot Password Title',
            'forgot_password_subject' => 'Forgot Password Subject',
            'forgot_password_content' => 'Forgot Password Content',
            'forgot_password_placeholders_hint' => 'You can use the following variables: {username}, {firstName}, {lastName}',
        ],
    ],

    'profile' => [
        'default_avatar_url' => 'Default Avatar URL',
        'default_avatar_url_hint' => 'You can use the following variables: {username}',
        'enable_change_avatar' => 'Enable Change Avatar',
        'enable_delete_account' => 'Enable Delete Account',
    ],

    'security' => [
        'password_minimum_length' => 'Password Minimum Length',
        'password_minimum_length_option' => '>= :length characters',
        'password_require_lowercase' => 'Password Require Lowercase',
        'password_require_uppercase' => 'Password Require Uppercase',
        'password_require_numbers' => 'Password Require Numbers',
        'password_require_special_characters' => 'Password Require Special Characters',
    ],
];
