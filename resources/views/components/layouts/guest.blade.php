<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ setting('app_name') }} | {{ $title ?? 'Page Title' }}</title>

    <link rel="icon" type="image/svg" href="{{ asset('img/Logo.svg') }}">

    @filamentStyles
    @vite(['resources/css/app.css'])
    @livewireStyles
    @livewireScripts
</head>
<body class="antialiased flex flex-col min-h-screen">
@livewire('notifications')
@livewire('wire-elements-modal')

{{ $slot }}


@filamentScripts
@vite('resources/js/app.js')
<script src="{{ asset('js/logger.js') }}"></script>

</body>
</html>
