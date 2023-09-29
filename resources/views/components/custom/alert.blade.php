@props(['icon' => '', 'disableIcon' => false])
<div {{ $attributes->merge(['class' => 'alert']) }}>
    @if(!$disableIcon || $disableIcon == 'false')
        <i class="{{ $icon }}"></i>
    @endif
    <span>{{ $slot }}</span>
</div>
