<?php

return [
    'welcome' => [
        // content, title, subject placeholders: :username, :password, :first_name, :last_name
        'title' => 'Welcome to ' . env('APP_NAME'),
        'subject' => 'Welcome to ' . env('APP_NAME'),
        'content' => 'Your account has been created. You can login with the following credentials: <br><br>Username: :username<br>Password: :password<br>',
    ],
    'forgot_password' => [
        // content, title, subject placeholders: :username, :first_name, :last_name, :reset_link, :password_reset_token
        'title' => 'Password reset for :username',
        'subject' => 'Password reset for :username',
        'content' => 'You are receiving this email because we received a password reset request for your account. <br><br>
        If you did not request a password reset, no further action is required. <br><br>
        The password reset link will expire in 24 hours. <br><br>
        Click the link below to reset your password: <br><br>
        <a href=":reset_link">Reset Password</a> <br><br>'
    ]
];
