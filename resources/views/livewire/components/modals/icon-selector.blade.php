<x-modal class="modal" size="w-11/12 max-w-5xl">
    <x-input label="{{ __('messages.search') }}"
             class="input input-bordered w-full" wire:model="search" wire:change="searchIcon"/>

    <button class="btn btn-neutral mt-5 w-full" wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>

    <div class="divider"></div>

    <div class="grid lg:grid-cols-12 md:grid-cols-9 sm:grid-cols-5 grid-cols-3 gap-4 mt-4">
        @foreach($icons as $icon)
            <button class="btn btn-ghost" wire:click="setIcon('{{ $icon }}')">
                <i class="{!! $icon !!} text-xl"></i>
            </button>
        @endforeach
    </div>
</x-modal>
