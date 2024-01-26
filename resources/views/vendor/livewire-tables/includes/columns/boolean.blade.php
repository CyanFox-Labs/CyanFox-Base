@if ($component->isTailwind())
    @if ($status)
        @if ($type === 'icons')
            @if ($successValue === true)
                <i class="icon-check-circle-2 text-xl text-green-500"></i>
            @else
                <i class="icon-check-circle-2 text-xl text-red-500"></i>
            @endif
        @elseif ($type === 'yes-no')
            @if ($successValue === true)
                <span>{{ __('messages.yes') }}</span>
            @else
                <span>{{ __('messages.no') }}</span>
            @endif
        @endif
    @else
        @if ($type === 'icons')
            @if ($successValue === false)
                <i class="icon-x-circle text-xl text-green-500"></i>
            @else
                <i class="icon-x-circle text-xl text-red-500"></i>
            @endif
        @elseif ($type === 'yes-no')
            @if ($successValue === false)
                <span>{{ __('messages.yes') }}</span>
            @else
                <span>{{ __('messages.no') }}</span>
            @endif
        @endif
    @endif
@elseif ($component->isBootstrap())
    @if ($status)
        @if ($type === 'icons')
            @if ($successValue === true)
                <i class="icon-x-circle text-xl text-success"></i>
            @else
                <i class="icon-x-circle text-xl text-danger"></i>
            @endif
        @elseif ($type === 'yes-no')
            @if ($successValue === true)
                <span>{{ __('messages.yes') }}</span>
            @else
                <span>{{ __('messages.no') }}</span>
            @endif
        @endif
    @else
        @if ($type === 'icons')
            @if ($successValue === false)
                <i class="icon-x-circle text-xl text-success"></i>
            @else
                <i class="icon-x-circle text-xl text-danger"></i>
            @endif
        @elseif ($type === 'yes-no')
            @if ($successValue === false)
                <span>{{ __('messages.yes') }}</span>
            @else
                <span>{{ __('messages.no') }}</span>
            @endif
        @endif
    @endif
@endif
