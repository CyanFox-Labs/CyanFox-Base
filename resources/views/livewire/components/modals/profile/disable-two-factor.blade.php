<x-modal id="disable_two_factor" class="modal-bottom sm:modal-middle">

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modal.disable_2fa.title') }}</h2>
            <p class="mb-3">{{ __('pages/profile.modal.disable_2fa.description') }}</p>

            <div class="flex justify-center">
                <div class="form-control w-full max-w-xs">
                    <label class="label" for="disable_two_factor_password">
                        <span class="label-text">{{ __('messages.password') }}</span>
                    </label>
                    <input type="password" id="disable_two_factor_password"
                           class="input input-bordered w-full max-w-xs mb-4"
                           wire:model="password"/>
                </div>
            </div>
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog">
                <button class="btn btn-neutral">{{ __('messages.cancel') }}</button>
                <button class="btn btn-success" wire:click="disableTwoFactor">{{ __('pages/profile.modal.disable_2fa.disable') }}</button>
            </form>
        </div>
</x-modal>
