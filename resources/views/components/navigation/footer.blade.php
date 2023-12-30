<footer class="w-full bg-base-200 p-4 flex items-center justify-between footer mt-auto z-10">
    <div class="flex-grow"></div>

    <div class="absolute left-0 right-0 mx-auto text-center text-sm md:block hidden" style="width: fit-content;">
        {{ __('messages.page') }} @if(env('APP_ENV') !== 'testing')
                {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
            @else
                0ms
            @endif
        &nbsp; | &nbsp;
        {{ __('messages.version') }} {{ \App\Http\Controllers\VersionController::getCurrentProjectVersion() }}
    </div>

    <div class="flex-grow"></div>

    <div class="text-right pr-5 text-sm">
        <p class="text-sm">{!! __('messages.made_with_love') !!}</p>
    </div>
</footer>
