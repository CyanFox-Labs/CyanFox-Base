<x-modal class="modal-bottom sm:modal-middle">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('components/modals/account/sessions.title') }}</h2>
        <p class="mb-3">{{ __('components/modals/account/sessions.description') }}</p>
    </div>


    <div class="divider"></div>

    <div class="mt-2 flex justify-between gap-3">

        <button class="btn btn-neutral flex-grow" type="button"
                wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>
        <button class="btn btn-success flex-grow" type="button"
                wire:click="logoutOtherDevices">{{ __('messages.buttons.confirm') }}</button>
    </div>
</x-modal>

