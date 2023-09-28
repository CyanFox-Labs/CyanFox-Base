<dialog id="activate_two_factor" class="modal">
    <div class="modal-box">

        <div class="flex justify-center">

            <img src="data:image/svg+xml;base64,{{ $twoFactorImage }}" alt="Two Factor Image"
                 class="border-4 border-white mr-6">

            <div class="space-y-4">
                <div class="form-control w-full max-w-xs">
                    <label class="label" for="two_factor_key">
                        <span class="label-text">Two-Factor Key</span>
                    </label>
                    <input type="number" id="two_factor_key" class="input input-bordered w-full max-w-xs"
                           wire:model="two_factor_key"/>
                </div>

                <div class="form-control w-full max-w-xs">
                    <label class="label" for="two_factor_password">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" id="two_factor_password" class="input input-bordered w-full max-w-xs"
                           wire:model="passwords.enable2fa"/>
                </div>
            </div>

        </div>


        <div class="modal-action">
            <form method="dialog" class="space-x-2">
                <button class="btn btn-neutral">Cancel</button>
                <button class="btn btn-success" wire:click="activateTwoFactor">Activate Two-Factor</button>
            </form>
        </div>
    </div>
</dialog>
