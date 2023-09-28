<dialog id="disable_two_factor" class="modal">
    <div class="modal-box">

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Disable Two-Factor</h2>
            <p class="mb-3">To disable Two-Factor, please enter your password </p>

            <div class="flex justify-center">
                <div class="form-control w-full max-w-xs">
                    <label class="label" for="disable_two_factor_password">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" id="disable_two_factor_password"
                           class="input input-bordered w-full max-w-xs mb-4"
                           wire:model="passwords.disable2fa"/>
                </div>
            </div>
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog" class="space-x-2">
                <button class="btn btn-neutral">Cancel</button>
                <button class="btn btn-success" wire:click="disableTwoFactor">Disable Two-Factor</button>
            </form>
        </div>
    </div>
</dialog>
