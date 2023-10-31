<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <div
        x-data="LivewireUIModal()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-on:keydown.escape.window="closeModalOnEscape()"
        x-show="show"
    >
        <div>
            <div
                x-show="show"
                x-on:click="closeModalOnClickAway()"
            >
            </div>

            <div
                x-show="show && showActiveComponent"
                x-bind:class="modalWidth"
                id="modal-container"
                x-trap.noscroll.inert="show && showActiveComponent"
                aria-modal="true"
                style="position: fixed; z-index: 9999;"
            >
                @forelse($components as $id => $component)
                    <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                        @livewire($component['name'], $component['arguments'], key($id))
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
