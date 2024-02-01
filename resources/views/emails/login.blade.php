{!! Str::markdown(str_replace(
    [
        '{username}',
        '{firstName}',
        '{lastName}',
        '{ipAddress}',
        '{userAgent}'
    ], [
        $username,
        $firstName,
        $lastName,
        $ipAddress,
        $userAgent
    ],
     setting('emails_login_content'))) !!}
