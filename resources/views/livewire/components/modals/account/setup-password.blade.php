<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.setup_password.title') }}</h2>
        <p class="mb-3">{{ __('pages/account/modals.setup_password.description') }}</p>

        <div class="flex justify-center">
            <div class="form-control w-full max-w-xs">
                <x-input label="{{ __('messages.password') }}"
                         type="password"
                         class="input input-bordered w-full max-w-xs mb-4"
                         wire:model="new_password"/>

                <x-input label="{{ __('messages.confirm_password') }}"
                         type="password"
                         class="input input-bordered w-full max-w-xs mb-4"
                         wire:model="confirm_password"/>
            </div>
        </div>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog" class="flex gap-2" wire:submit="setupPassword">
            <button class="btn btn-neutral" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <x-button class="btn btn-success"
                      type="submit" spinner="setupPassword">{{ __('messages.confirm') }}</x-button>
        </form>
    </div>
</x-modal>
