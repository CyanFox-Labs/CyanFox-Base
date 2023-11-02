<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }} | {{ $title ?? 'Page Title' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">

    @filamentStyles
    @vite(['resources/css/app.css'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="antialiased">
@livewire('notifications')
@livewire('wire-elements-modal')

{{ $slot }}


<!-- Scripts -->
@livewireScripts
@filamentScripts
@vite('resources/js/app.js')

<script src="{{ asset('js/hcaptcha.js') }}"></script>
<script src="{{ asset('js/error_log.js') }}"></script>
</body>
</html>
