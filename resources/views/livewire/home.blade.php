<div>
    <livewire:components.notifications site="home"/>

    @isset($moduleComponent)
        @component($moduleComponent['component'])
        @endcomponent
    @endisset
</div>
