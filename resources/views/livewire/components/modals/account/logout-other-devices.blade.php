<x-modal class="modal-bottom sm:modal-middle">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('account/profile.modals.logout_other_devices.title') }}</h2>
        <p class="mb-3">{{ __('account/profile.modals.logout_other_devices.description') }}</p>
    </div>


    <div class="divider"></div>

    <div class="mt-2 flex justify-between gap-3">

        <button class="btn btn-neutral flex-grow" type="button"
                wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>
        <x-button class="btn btn-success flex-grow" type="button"
                wire:click="logoutOtherDevices" spinner>{{ __('account/profile.modals.logout_other_devices.buttons.logout_other_devices') }}</x-button>
    </div>
</x-modal>

