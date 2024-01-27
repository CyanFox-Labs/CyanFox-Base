{!! Str::markdown(str_replace(
    [
        '{username}',
        '{firstName}',
        '{lastName}',
        '{password}',
        '{loginLink}'
    ], [
        $username,
        $firstName,
        $lastName,
        $password,
        route('auth.login')
    ],
     setting('emails_welcome_content'))) !!}
