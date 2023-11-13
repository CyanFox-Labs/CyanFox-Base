<footer class="p-4 bg-base-200 mt-auto z-10 sm:block hidden">
    <aside>
        <div class="flex justify-center">
            <p>{{ __('messages.page') }} @if(env('APP_ENV') !== 'testing')
                    {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
                @else
                    0ms
                @endif </p>
            <p>&nbsp; | &nbsp;</p>
            <p>{{ __('messages.version') }} {{ \App\Http\Controllers\VersionController::getCurrentProjectVersion() }}</p>
        </div>
        <div class="flex items-end justify-end text-end">
            <p class="text-sm text-gray-500">{!! __('messages.made_with_love') !!}</p>
        </div>
    </aside>
</footer>
