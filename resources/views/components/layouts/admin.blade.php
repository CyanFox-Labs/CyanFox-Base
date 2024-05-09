<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', setting('app_lang')) }}" @if(auth()->user())
    data-theme="{{ auth()->user()->theme }}"
      @if(
    user()->getUser(auth()->user())->getColorScheme() == 'dark'
    ) class="dark" @endif>
@endif
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ setting('app_name') }} | {{ $title ?? '' }}</title>

    <link rel="icon" href="{{ asset(setting('logo_path')) }}">

    @filamentStyles
    @vite('resources/css/app.css')
    @livewireStyles
    @livewireScripts
</head>
<body class="antialiased flex flex-col min-h-screen">
@livewire('notifications')
@livewire('wire-elements-modal')


<x-navigation.admin :content="$slot"/>

<x-navigation.footer/>

<x-spotlight
        shortcut="ctrl.e"
        no-results-text="{{ __('navigation.spotlight.nothing_found') }}"
/>

@filamentScripts
@vite('resources/js/app.js')
<script src="{{ asset('js/logger.js') }}"></script>

</body>
</html>
