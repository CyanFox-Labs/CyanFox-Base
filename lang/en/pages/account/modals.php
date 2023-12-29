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
        'buttons' => [
            'regenerate' => 'Regenerate',
        ]
    ],

    'new_api_key' => [
        'created' => [
            'title' => 'API Key Created',
            'description' => 'Please copy your new API key. You won\'t be able to see it again!',
        ],

        'title' => 'New API Key',
        'description' => 'Please enter a name for your new API key.',

        'buttons' => [
            'create_api_key' => 'Create API Key',
        ]
    ],

    'revoke_api_key' => [
        'title' => 'Revoke API Key',
        'description' => 'Are you sure you want to revoke this API key?',
        'buttons' => [
            'revoke_api_key' => 'Revoke API Key',
        ]
    ],

    'setup_password' => [
        'title' => 'Setup Password',
        'description' => 'Please enter a password for your account. You will also be able to login using this password',
    ],

    'delete_account' => [
        'title' => 'Delete Account',
        'description' => 'Are you sure you want to delete your account? All of your data will be permanently deleted. This action cannot be undone.',
        'buttons' => [
            'delete_account' => 'Delete Account',
        ]
    ],

    'upload_profile_image' => [
        'title' => 'Upload Profile Image',
        'description' => 'Please select an image to upload.',
        'label' => 'Profile Image',
        'buttons' => [
            'reset_image' => 'Reset Image',
            'upload_profile_image' => 'Upload Profile Image',
        ]
    ],
];
