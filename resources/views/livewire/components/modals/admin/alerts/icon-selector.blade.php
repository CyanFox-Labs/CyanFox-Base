<x-modal class="modal-bottom sm:modal-middle">
    <x-input label="{{ __('pages/admin/alerts/messages.search') }}"
             class="input input-bordered w-full" wire:model="search" wire:change="searchIcon"/>

    <button class="btn btn-neutral mt-5 w-full" wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>


    <div class="grid lg:grid-cols-12 md:grid-cols-9 sm:grid-cols-5 grid-cols-3 gap-4 mt-4">
        @foreach($icons as $icon)
            <button class="btn btn-ghost" wire:click="setIcon('{{ $icon }}')">
                <i class="{!! $icon !!} text-xl"></i>
            </button>
        @endforeach
    </div>
</x-modal>
