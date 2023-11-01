<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modals.disable_2fa.title') }}</h2>
        <p class="mb-3">{{ __('pages/profile.modals.disable_2fa.description') }}</p>

        <div class="flex justify-center">
            <div class="form-control w-full max-w-xs">
                <x-input label="{{ __('messages.password') }}"
                         type="password"
                         class="input input-bordered w-full max-w-xs mb-4"
                         wire:model="password"/>
            </div>
        </div>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog" class="flex gap-2" wire:submit="disableTwoFactor">
            <button class="btn btn-neutral" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <x-button class="btn btn-success"
                    type="submit" spinner="disableTwoFactor">{{ __('pages/profile.modals.disable_2fa.disable') }}</x-button>
        </form>
    </div>
</x-modal>
