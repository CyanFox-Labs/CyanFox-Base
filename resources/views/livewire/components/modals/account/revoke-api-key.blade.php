<x-modal class="modal-bottom sm:modal-middle">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.revoke_api_key.title') }}</h2>
        <p class="mb-3">{{ __('pages/account/modals.revoke_api_key.description') }}</p>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog" class="flex gap-2" wire:submit="revokeApiKey">
            <button class="btn btn-neutral" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <x-button class="btn btn-success"
                      type="submit" spinner="revokeApiKey">{{ __('pages/account/modals.revoke_api_key.buttons.revoke_api_key') }}</x-button>
        </form>
    </div>
</x-modal>

