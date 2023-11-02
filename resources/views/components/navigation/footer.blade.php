<footer class="p-4 bg-base-200 mt-auto z-10">
    <aside class="flex justify-center">
        <p>{{ __('messages.page') }} @if(!env('APP_ENV') == 'testing')
                {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
            @else
                0ms
            @endif </p>
        <p>&nbsp; | &nbsp;</p>
        <p>{{ __('messages.version') }} {{ \App\Http\Controllers\VersionController::getCurrentProjectVersion() }}</p>
    </aside>
</footer>
