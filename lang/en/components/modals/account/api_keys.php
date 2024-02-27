<?php

return [

    'create_api_key' => [
        'title' => 'Create API Key',
        'description' => 'Please enter a name for your API key.',
        'name' => 'Name',

        'plain_text_token' => [
            'title' => 'API Key Created',
            'description' => 'Store this API key in a safe place. It will not be shown again.',
        ],

        'notifications' => [
            'api_key_created' => 'API key created successfully!',
        ],
    ],

    'delete_api_key' => [
        'title' => 'Delete API Key',
        'description' => 'Are you sure you want to delete this API key?',

        'notifications' => [
            'api_key_deleted' => 'API key deleted successfully!',
        ],
    ],
];
