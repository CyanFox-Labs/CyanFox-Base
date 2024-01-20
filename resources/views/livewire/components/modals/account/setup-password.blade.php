<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('components/modals/account/setup_password.title') }}</h2>
        <p class="mb-3">{{ __('components/modals/account/setup_password.description') }}</p>
    </div>

    <form method="dialog" wire:submit="setupPassword">
        <div class="md:flex justify-center">

            <div class="space-y-4 mb-4 md:mt-2 mt-6">
                <x-input label="{{ __('components/modals/account/setup_password.new_password') }}"
                         type="password" class="input input-bordered"
                         wire:model="newPassword"/>

                <x-input label="{{ __('components/modals/account/setup_password.confirm_new_password') }}"
                         type="password" class="input input-bordered"
                         wire:model="passwordConfirmation"/>
            </div>

        </div>

        <div class="divider mt-4"></div>

        <div class="mt-2 flex justify-between gap-3">
            <button class="btn btn-neutral flex-grow" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>

            <x-button class="btn btn-success flex-grow"
                      type="submit" spinner="setupPassword">
                {{ __('messages.buttons.save') }}
            </x-button>
        </div>
    </form>
</x-modal>
