@props([
    'target' => '',
    'backUrl' => null,
    'showUpdate' => true,
    'showCancel' => true,
    'updateText' => __('messages.buttons.update'),
    'cancelText' => __('messages.buttons.cancel'),
])
<x-divider/>

<div {{ $attributes->merge(['class' => 'flex sm:flex-row flex-col sm:space-x-2 sm:space-y-0 space-y-2 mt-4']) }}>
    @if ($showUpdate)
        <x-button loading="{{ $target }}"
                  type="submit">{{ $updateText }}</x-button>
    @endif

    {{ $slot }}

    @if ($showCancel)
        <x-button type="button" href="{{ $backUrl ?? url()->previous() }}" color="gray"
                  wire:navigate>{{ $cancelText }}</x-button>
    @endif
</div>
