<x-modal class="modal" size="w-11/12 max-w-5xl">
    <div wire:ignore>

        <x-diff :old="$old" :new="$new" :config="$config" file-name="{{ $name }}"/>

    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog">
            <button class="btn btn-neutral" wire:click="$dispatch('closeModal')">{{ __('messages.buttons.close') }}</button>
        </form>
    </div>
</x-modal>
