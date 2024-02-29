<?php

return [
    'name' => 'Name',
    'guard_name' => 'Guard Name',
    'permissions' => 'Permissions',

    'modals' => [
        'delete_group' => [
            'title' => 'Delete Group',
            'description' => 'Are you sure you want to delete this group?',

            'notifications' => [
                'group_deleted' => 'Group deleted successfully!',
            ],
            'buttons' => [
                'delete_group' => 'Delete Group',
            ],
        ],
    ],

    'list' => [
        'tab_title' => 'Admin • Groups',
        'title' => 'Groups',
        'buttons' => [
            'create_group' => 'Create Group',
        ],
        'table' => [
            'name' => 'Name',
            'guard_name' => 'Guard Name',
        ],
    ],

    'create' => [
        'tab_title' => 'Admin • Groups » Create Group',
        'title' => 'Create Group',

        'notifications' => [
            'group_created' => 'Group created successfully!',
        ],
        'buttons' => [
            'create_group' => 'Create Group',
        ],
    ],

    'update' => [
        'tab_title' => 'Admin • Groups » Update :group',
        'title' => 'Update Group',

        'notifications' => [
            'group_updated' => 'Group updated successfully!',
        ],
        'buttons' => [
            'update_group' => 'Update Group',
        ],
    ],
];
