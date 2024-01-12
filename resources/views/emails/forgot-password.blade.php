{!! Str::markdown(str_replace(
    [
        '{username}',
        '{first_name}',
        '{last_name}',
        '{reset_link}'
    ], [
        $username,
        $first_name,
        $last_name,
        route('auth.forgot-password', [$password_reset_token])
    ],
     get_setting('emails', 'forgot_password.content'))) !!}
