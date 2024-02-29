<?php

return [
    'tab_title' => 'Install',
    'tabs' => [
        'database' => 'Database',
        'system' => 'System',
        'email' => 'Email',
        'create_user' => 'Create User',
    ],

    'buttons' => [
        'next' => 'Next',
        'back' => 'Back',
        'finish' => 'Finish',
    ],

    'database' => [
        'host' => 'Host',
        'port' => 'Port',
        'database' => 'Database',
        'username' => 'Username',
        'password' => 'Password',

        'alerts' => [
            'success' => [
                'title' => 'Database Connection Successful',
                'message' => 'The database connection was successful.',
            ],
            'error' => [
                'title' => 'Database Connection Error',
            ],
        ],

        'buttons' => [
            'test_connection' => 'Test Connection',
        ]
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
    ],

    'email' => [
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
];
