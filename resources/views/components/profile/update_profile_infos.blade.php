<dialog id="show_profile_infos" class="modal">
    <div class="modal-box">

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Update Profile Information?</h2>
            <p class="mb-3">Please enter your password to confirm you would like to update your Profile
                Information.</p>

            <div class="flex justify-center">
                <div class="form-control w-full max-w-xs">
                    <label class="label" for="logout_sessions_password">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" id="logout_sessions_password"
                           class="input input-bordered w-full max-w-xs mb-4"
                           wire:model="passwords.updateProfileInfos"/>
                </div>
            </div>
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog" class="space-x-2">
                <button class="btn btn-neutral">Cancel</button>
                <button class="btn btn-success" wire:click="updateProfileInfos">Update</button>
            </form>
        </div>
    </div>
</dialog>
