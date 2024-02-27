<?php

return [
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
];
