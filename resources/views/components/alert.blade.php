@props(['type' => 'success', 'icon' => '', 'disableIcon' => false])
<div {{ $attributes->merge(['class' => 'alert alert-' . $type]) }}>
    @if(!$disableIcon || $disableIcon == 'false')
        <i class="{{ $icon }}"></i>
    @endif
    <span>{{ $slot }}</span>
</div>
