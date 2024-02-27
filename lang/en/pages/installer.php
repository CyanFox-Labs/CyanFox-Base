<?php

return [
    'database' => [
        'host' => 'Host',
        'port' => 'Port',
        'database' => 'Database',
        'username' => 'Username',
        'password' => 'Password',
        'buttons' => [
            'test' => 'Test Connection',
        ],
        'alerts' => [
            'success' => [
                'title' => 'Connection successful',
                'message' => 'The connection to the database was successful.',
            ],
            'error' => [
                'title' => 'Connection failed',
            ],
        ],
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
        'buttons' => [
            'save' => 'Save',
        ],
    ],

    'email' => [
        'tabs' => [
            'forgot_password' => 'Forgot Password',
            'login' => 'Login',
            'welcome' => 'Welcome',
        ],

        'welcome' => [
            'title' => 'Welcome title',
            'subject' => 'Welcome subject',
            'content' => 'Welcome content',
            'hints' => [
                'title' => 'You can use the following variables: {username}, {firstName}, {lastName}, {password}, {loginLink}, {appName}',
                'subject' => 'You can use the following variables: {username}, {firstName}, {lastName}, {password}, {loginLink}, {appName}',
                'content' => 'You can use the following variables: {username}, {firstName}, {lastName}, {password}, {loginLink}, {appName}',
            ],
        ],

        'login' => [
            'enable_login' => 'Enable login email',
            'title' => 'Login title',
            'subject' => 'Login subject',
            'content' => 'Login content',
            'hints' => [
                'title' => 'You can use the following variables: {username}, {firstName}, {lastName}, {ipAddress}, {userAgent}',
                'subject' => 'You can use the following variables: {username}, {firstName}, {lastName}, {ipAddress}, {userAgent}',
                'content' => 'You can use the following variables: {username}, {firstName}, {lastName}, {ipAddress}, {userAgent}',
            ],
        ],

        'forgot_password' => [
            'title' => 'Forgot password title',
            'subject' => 'Forgot password subject',
            'content' => 'Forgot password content',
            'hints' => [
                'title' => 'You can use the following variables: {username}, {firstName}, {lastName}',
                'subject' => 'You can use the following variables: {username}, {firstName}, {lastName}',
                'content' => 'You can use the following variables: {username}, {firstName}, {lastName}, {loginLink}',
            ],
        ],
    ],

    'create_user' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'username' => 'Username',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Password Confirmation',
    ],

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
];
