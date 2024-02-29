<?php

return [
    'permissions' => 'Permissions',
    'groups' => 'Groups',
    'force_activate_two_factor' => 'Force Activate Two Factor',
    'force_change_password' => 'Force Change Password',
    'disabled' => 'Disabled',

    'modals' => [
        'delete_user' => [
            'title' => 'Delete User',
            'description' => 'Are you sure you want to delete this user?',

            'notifications' => [
                'user_deleted' => 'User deleted successfully!',
            ],
            'buttons' => [
                'delete_user' => 'Delete User',
            ],
        ],
    ],

    'list' => [
        'tab_title' => 'Admin • Users',
        'title' => 'Users',
        'buttons' => [
            'create_user' => 'Create User',
        ],
        'table' => [
            'avatar' => 'Avatar',
            'two_factor_enabled' => 'Two Factor Enabled',
        ],
    ],
    'create' => [
        'tab_title' => 'Admin • Users » Create User',
        'title' => 'Create User',
        'send_welcome_email' => 'Send Welcome Email',

        'notifications' => [
            'user_created' => 'User created successfully!',
        ],
        'buttons' => [
            'create_user' => 'Create User',
        ],
    ],
    'update' => [
        'tab_title' => 'Admin • Users » Update :user',
        'title' => 'Update User',

        'notifications' => [
            'user_updated' => 'User updated successfully!',
        ],
        'buttons' => [
            'update_user' => 'Update User',
        ],
    ],
];
