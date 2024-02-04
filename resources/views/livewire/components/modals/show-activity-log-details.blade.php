<x-modal class="modal" size="w-11/12 max-w-5xl">
    <div wire:ignore>

        <x-diff :old="$old" :new="$new" :config="$config" file-name="{{ $name }}"/>

    </div>

    <div class="divider"></div>

    <div class="mt-2 flex justify-between gap-3">
        <button class="btn btn-neutral" wire:click="$dispatch('closeModal')">{{ __('messages.buttons.close') }}</button>
    </div>
</x-modal>
