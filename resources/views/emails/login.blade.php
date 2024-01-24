{!! Str::markdown(str_replace(
    [
        '{username}',
        '{firstName}',
        '{lastName}',
        '{ipAddress}'
    ], [
        $username,
        $firstName,
        $lastName,
        $ipAddress
    ],
     setting('emails_login_content'))) !!}
