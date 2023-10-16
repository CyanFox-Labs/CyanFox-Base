<x-modal id="activate_two_factor" class="modal-bottom sm:modal-middle">

    <div class="flex justify-center">

        <img src="data:image/svg+xml;base64,{{ $twoFactorImage }}" alt="Two Factor Image"
             class="border-4 border-white mr-6">

        <div class="space-y-4">
            <div class="form-control w-full max-w-xs">
                <label class="label" for="two_factor_key">
                    <span class="label-text">{{ __('pages/profile.modal.activate_2fa.key') }}</span>
                </label>
                <input type="number" id="two_factor_key" class="input input-bordered w-full max-w-xs"
                       wire:model="two_factor_key"/>
            </div>

            <div class="form-control w-full max-w-xs">
                <label class="label" for="two_factor_password">
                    <span class="label-text">{{ __('messages.password') }}</span>
                </label>
                <input type="password" id="two_factor_password" class="input input-bordered w-full max-w-xs"
                       wire:model="password"/>
            </div>
        </div>

    </div>


    <div class="modal-action">
        <form method="dialog">
            <button class="btn btn-neutral">{{ __('messages.cancel') }}</button>
            <button class="btn btn-success"
                    wire:click="activateTwoFactor">{{ __('pages/profile.modal.activate_2fa.activate') }}</button>
        </form>
    </div>
</x-modal>
