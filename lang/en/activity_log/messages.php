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
    ],

    'account' => [
        'forgot_password_requested' => 'account:forgot_password.requested',
        'forgot_password_request_failed' => 'account:forgot_password.request_failed',
        'forgot_password_success' => 'account:forgot_password.success',
        'forgot_password_failed' => 'account:forgot_password.failed',
        'change_password_success' => 'account:change_password.success',
        'change_password_failed' => 'account:change_password.failed',
        'activate_two_factor_success' => 'account:activate_two_factor.success',
        'activate_two_factor_failed' => 'account:activate_two_factor.failed',
        'disable_two_factor_failed' => 'account:disable_two_factor.failed',
        'disable_two_factor_success' => 'account:disable_two_factor.success',
        'revoke_all_sessions_failed' => 'account:revoke_all_sessions.failed',
        'revoke_all_sessions_success' => 'account:revoke_all_sessions.success',
        'revoke_session_failed' => 'account:revoke_session.failed',
        'revoke_session_success' => 'account:revoke_session.success',
        'api_key_created' => 'account:api_key.created',
        'api_key_revoked' => 'account:api_key.revoked',
        'recovery_codes_downloaded' => 'account:recovery_codes.downloaded',
        'recovery_codes_shown' => 'account:recovery_codes.shown',
        'recovery_codes_regenerated' => 'account:recovery_codes.regenerated',
        'profile_update_failed' => 'account:profile.update_failed',
        'profile_update_success' => 'account:profile.update_success',
        'language_change_success' => 'account:language.change_success',
        'language_change_failed' => 'account:language.change_failed',
        'theme_change_success' => 'account:theme.change_success',
        'theme_change_failed' => 'account:theme.change_failed',
        'delete_account_success' => 'account:delete_account.success',
    ],

    'check_for_updates' => 'system:check_for_updates',
];
