<x-modal class="modal-bottom sm:modal-middle">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('account/profile.modals.delete_api_key.title') }}</h2>
        <p class="mb-3">{{ __('account/profile.modals.delete_api_key.description') }}</p>
    </div>

    <div class="divider"></div>

    <div class="mt-2 flex justify-between gap-3">
        <button class="btn btn-neutral flex-grow" type="button"
                wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>
        <x-button class="btn btn-error flex-grow" type="button"
                wire:click="deleteAPIKey" spinner>{{ __('account/profile.modals.delete_api_key.buttons.delete_api_key') }}</x-button>
    </div>
</x-modal>

