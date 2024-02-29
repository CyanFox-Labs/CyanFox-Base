<?php

return [
    'rate_limit' => 'Max login attempts reached! Retry after :seconds seconds.',
    'user_not_found' => 'This user account does not exist.',
    'buttons' => [
        'back_to_login' => 'Back to Login',
    ],
    'login' => [
        'tab_title' => 'Login',
        'remember_me' => 'Remember Me',
        'two_factor_or_recovery_code' => 'Two-Factor or Recovery Code',
        'user_disabled' => 'This user account is disabled.',

        'buttons' => [
            'login' => 'Login',
            'forgot_password' => 'Forgot Your Password?',
            'register' => 'Register',
        ],

        'login_with' => [
            'github' => '<i class="bi bi-github"></i>',
            'google' => '<i class="bi bi-google"></i>',
            'discord' => '<i class="bi bi-discord"></i>',
        ],
    ],
    'register' => [
        'tab_title' => 'Register',

        'notifications' => [
            'registered' => 'You have been registered!',
        ],
        'buttons' => [
            'register' => 'Register',
        ],
    ],
    'forgot_password' => [
        'tab_title' => 'Forgot Password',

        'notifications' => [
            'reset_link_sent' => 'We have emailed your password reset link!',
            'reset_link_invalid' => 'This password reset link is invalid.',
            'reset_link_expired' => 'This password reset link has expired.',
            'password_reset' => 'Your password has been reset!',
        ],
        'buttons' => [
            'send_reset_link' => 'Send Password Reset Link',
            'reset_password' => 'Reset Password',
        ],
    ],
];
