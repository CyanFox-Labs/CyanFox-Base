@props([
    'title' => null,
    'viewIntegration' => null,
])
<x-card>
    <x-slot:header>
        <span class="font-bold text-xl">{{ __($title) }}</span>
        <x-view-integration name="{{ $viewIntegration }}.title"/>
    </x-slot:header>

    <x-view-integration name="{{ $viewIntegration }}.header"/>

    {{ $slot }}

    <x-view-integration name="{{ $viewIntegration }}.footer"/>
</x-card>
