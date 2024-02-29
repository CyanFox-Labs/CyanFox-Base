<footer class="w-full bg-base-200 p-4 flex items-center justify-between footer mt-auto z-0">
    <div class="flex-grow"></div>

    <div class="absolute left-0 right-0 mx-auto text-center text-sm md:block hidden">
        {{ __('navigation.footer.page') }} @if(config('app.env') !== 'testing')
            {{ round((microtime(true) - LARAVEL_START) * 1000, 2) }}ms
        @else
            0ms
        @endif
        <span class="px-2">|</span>
        {{ __('navigation.footer.version') }} {{ version()->getCurrentProjectVersion()  }}
    </div>


    <div class="text-right pr-5">
        <p class="text-sm z-10">{!! __('navigation.footer.made_with_love') !!}</p>
    </div>
</footer>
