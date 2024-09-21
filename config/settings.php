<?php

return [
    'name' => env('APP_NAME', 'Laravel'),
    'logo_path' => env('APP_LOGO_PATH', 'img/Logo.svg'),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'lang' => env('APP_LOCALE', 'en'),
    'versions' => [
        'template_url' => env('TEMPLATE_VERSION_URL', 'N/A'),
        'project_url' => env('PROJECT_VERSION_URL', 'N/A'),
    ],
    'unsplash' => [
        'api_key' => env('UNSPLASH_API_KEY'),
        'utm' => env('UNSPLASH_UTM', '?utm_source=APP_NAME&utm_medium=referral'),
        'fallback_css' => env('UNSPLASH_FALLBACK_CSS',
            'background: rgb(2,0,36); background: linear-gradient(310deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%);'),
    ],
    'telemetry' => [
        'enabled' => env('TELEMETRY_ENABLED', false),
        'url' => env('TELEMETRY_URL'),
        'instance' => env('TELEMETRY_INSTANCE'),
    ],
    'force_https' => env('FORCE_HTTPS', false),
    'disable_db_settings' => env('DISABLE_DB_SETTINGS', false),
];
