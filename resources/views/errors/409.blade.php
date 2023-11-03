<!DOCTYPE html>
<!--
    https://github.com/tarampampam/error-pages
    Error 409: Conflict
    Description: The request could not be completed because of a conflict
-->
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="noindex, nofollow"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>409 | {{ __('pages/errors.codes.409') }}</title>
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
</head>
<body>
<header>
    <h1 class="error-code">409</h1>
    <p class="error-description">{{ __('pages/errors.codes.409') }}</p>
</header>
<div class="status">
    <div class="card error" id="client-status-card">
        <i class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path
                    d="M19 4H5c-1.11 0-2 .9-2 2v12c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.89-2-2-2zm0 14H5V8h14v10z"/>
            </svg>
        </i>
        <main>{{ __('pages/errors.your_client') }}</main>
        <p class="status-text">{{ __('pages/errors.codes.409') }}</p>
    </div>

    <div class="arrows">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#000000">
            <defs>
                <symbol id="arrows-horizontal" viewBox="0 0 24 24">
                    <rect fill="none" height="24" width="24" x="0"/>
                    <polygon points="7.41,13.41 6,12 2,16 6,20 7.41,18.59 5.83,17 21,17 21,15 5.83,15"/>
                    <polygon points="16.59,10.59 18,12 22,8 18,4 16.59,5.41 18.17,7 3,7 3,9 18.17,9"/>
                </symbol>
            </defs>
            <use href="#arrows-horizontal"/>
        </svg>
    </div>

    <div class="card ok" id="network-status-card">
        <i class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path
                    d="M12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5 1.53.11c1.56.1 2.78 1.41 2.78 2.96 0 1.65-1.35 3-3 3H6c-2.21 0-4-1.79-4-4 0-2.05 1.53-3.76 3.56-3.97l1.07-.11.5-.95C8.08 7.14 9.94 6 12 6m0-2C9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96C18.67 6.59 15.64 4 12 4z"/>
            </svg>
        </i>
        <main>{{ __('pages/errors.network') }}</main>
        <p class="status-text">{{ __('pages/errors.working') }}</p>
    </div>

    <div class="arrows">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" fill="#000000">
            <use href="#arrows-horizontal"/>
        </svg>
    </div>

    <div class="card ok" id="server-status-card">
        <i class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                <path d="M0 0h24v24H0V0z" fill="none"/>
                <path
                    d="M19 15v4H5v-4h14m1-2H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zM7 18.5c-.82 0-1.5-.67-1.5-1.5s.68-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM19 5v4H5V5h14m1-2H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zM7 8.5c-.82 0-1.5-.67-1.5-1.5S6.18 5.5 7 5.5s1.5.68 1.5 1.5S7.83 8.5 7 8.5z"/>
            </svg>
        </i>
        <main>{{ __('pages/errors.web_server') }}</main>
        <p class="status-text">{{ __('pages/errors.working') }}</p>
    </div>
</div>
<div class="reason">
    <div class="what-happened">
        <h2>{{ __('pages/errors.what_happened') }}</h2>
        <p class="description">{{ __('pages/errors.what_happened_descriptions.409') }}</p>
    </div>
    <div class="what-can-i-do">
        <h2>{{ __('pages/errors.what_can_i_do') }}</h2>
        <p class="description">{!! __('pages/errors.what_can_i_do_descriptions.nothing_you_can_do', ['here' => route('home')]) !!}</p>
    </div>
</div>
</body>
</html>
