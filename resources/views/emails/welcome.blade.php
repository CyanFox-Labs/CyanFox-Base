{!! Str::markdown(str_replace(
    [
        '{username}',
        '{firstName}',
        '{lastName}',
        '{password}',
        '{appName}',
        '{loginLink}'
    ], [
        $username,
        $firstName,
        $lastName,
        $password,
        setting('app_name'),
        route('auth.login')
    ],
     setting('emails_welcome_content'))) !!}
