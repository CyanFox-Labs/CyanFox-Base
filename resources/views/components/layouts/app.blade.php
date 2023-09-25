<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>

<x-navigation.sidebar></x-navigation.sidebar>
{{ $slot }}

@livewireScripts
</body>
</html>
