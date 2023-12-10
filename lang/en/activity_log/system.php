<?php

return [
    'user' => [
        'deleted' => 'system:user.deleted',
        'updated' => 'system:user.updated',
        'created' => 'system:user.created',
    ],

    'group' => [
        'deleted' => 'system:group.deleted',
        'updated' => 'system:group.updated',
        'created' => 'system:group.created',
    ],

    'auth' => [
        'login' => 'auth:login',
        'logout' => 'auth:logout',
        'failed' => 'auth:failed',
        'two_factor_requested' => 'auth:two_factor.requested',
        'two_factor_failed' => 'auth:two_factor.failed',
        'two_factor_success' => 'auth:two_factor.success',
        'register' => 'auth:register',
        'register_failed' => 'auth:register.failed',
        'forgot_password_requested' => 'auth:forgot_password.requested',
        'forgot_password_request_failed' => 'auth:forgot_password.request_failed',
        'forgot_password_success' => 'auth:forgot_password.success',
        'forgot_password_failed' => 'auth:forgot_password.failed',
    ],

    'check_for_updates' => 'system:check_for_updates',
];
