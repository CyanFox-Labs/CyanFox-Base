<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modals.logout_all.title') }}</h2>
        <p class="mb-3">{{ __('pages/profile.modals.logout_all.description') }}</p>

        <div class="flex justify-center">
            <div class="form-control w-full max-w-xs">
                <label class="label" for="logout_sessions_password">
                    <span class="label-text">{{ __('messages.password') }}</span>
                </label>
                <input type="password" id="logout_sessions_password"
                       class="input input-bordered w-full max-w-xs mb-4"
                       wire:model="password"/>
            </div>
        </div>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog">
            <button class="btn btn-neutral" wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <button class="btn btn-success" wire:click="logoutAllSessions">{{ __('pages/profile.modals.logout_all.logout') }}</button>
        </form>
    </div>
</x-modal>
