<?php

return [
    'disable_two_factor' => [
        'title' => 'Disable Two Factor Authentication',
        'description' => 'Are you sure you want to disable two factor authentication?',
    ],
    'logout' => [
        'title' => 'Logout',
        'description' => 'You clicked your own Session Logout button. Are you sure you want to logout?',
    ],

    'revoke_all_sessions' => [
        'title' => 'Revoke All Sessions',
        'description' => 'Are you sure you want to revoke all sessions?',
        'buttons' => [
            'revoke_all_sessions' => 'Revoke All Sessions',
        ]
    ],

    'revoke_session' => [
        'title' => 'Revoke Session',
        'description' => 'Are you sure you want to revoke this session?',
        'buttons' => [
            'revoke_session' => 'Revoke Session',
        ]
    ],

    'recovery_codes' => [
        'password' => [
            'title' => 'Recovery Codes',
            'description' => 'To show your recovery codes, please enter your password.',
            'buttons' => [
                'show_recovery_codes' => 'Show Recovery Codes',
            ]
        ],
        'title' => 'Recovery Codes',
        'description' => 'Recovery codes are used to access your account in the event you lose access to your two factor authentication device.',
    ]
];
