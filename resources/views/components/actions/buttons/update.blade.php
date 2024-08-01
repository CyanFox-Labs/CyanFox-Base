@props([
    'target' => '',
    'showUpdate' => true,
    'showCancel' => true,
    'updateText' => __('messages.buttons.update'),
    'cancelText' => __('messages.buttons.cancel'),
])

<div {{ $attributes->merge(['class' => 'flex items-center space-x-2']) }}>
    @if ($showCreate)
        <x-button loading="{{ $target }}"
                  type="submit">{{ $updateText }}</x-button>
    @endif

    @if ($showCancel)
        <x-button href="{{ url()->previous() }}" color="gray" wire:navigate>{{ $cancelText }}</x-button>
    @endif
</div>
