<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modals.logout_specific.title') }}</h2>
        <p class="mb-3">{{ __('pages/profile.modals.logout_specific.description') }}</p>
    </div>
    <div class="flex justify-center">
        <div class="form-control w-full max-w-xs">
            <x-input label="{{ __('messages.password') }}"
                     type="password"
                     wire:model="password"
                     class="input input-bordered w-full max-w-xs mb-4"/>
        </div>
    </div>
    <div class="flex justify-center modal-action">
        <form method="dialog" class="flex gap-2" wire:submit="logoutSession">
            <button class="btn btn-neutral" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <x-button class="btn btn-danger"
                    type="submit" spinner="logoutSession">{{ __('pages/profile.modals.logout.logout') }}
            </x-button>
        </form>
    </div>
</x-modal>
