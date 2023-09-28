<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ auth()->user()->theme }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>

<x-navigation.sidebar></x-navigation.sidebar>

{{ $slot }}

@livewireScripts

@if(auth()->user()->theme != 'light') <link href="{{ asset('css/sweetalert.dark.css') }}" rel="stylesheet"> @endif
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
<x-livewire-alert::flash />
</body>
</html>
