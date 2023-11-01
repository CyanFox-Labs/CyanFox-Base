<footer class="p-4 bg-navigation text-white mt-auto z-10">
    <aside class="flex justify-center">
        <p>{{ __('messages.page') }} {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms</p>
        <p>&nbsp; | &nbsp;</p>
        <p>{{ __('messages.version') }} {{ \App\Http\Controllers\VersionController::getCurrentProjectVersion() }}</p>
    </aside>
</footer>
