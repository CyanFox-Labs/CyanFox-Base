<x-modal class="modal-bottom sm:modal-middle">

    <div class="text-center">
        <h2 class="text-2xl font-bold mb-4">{{ __('components/modals/account/disable_two_factor.title') }}</h2>
        <p class="mb-3">{{ __('components/modals/account/disable_two_factor.description') }}</p>
    </div>

    <x-form wire:submit="disableTwoFactor">
        @csrf
        <div class="md:flex justify-center mb-3">

            <div class="space-y-4 mb-4 md:mt-2 mt-6">
                <x-input label="{{ __('messages.password') }}"
                         type="password" class="input input-bordered"
                         wire:model="password" required/>
            </div>

        </div>

        <div class="divider"></div>

        <div class="mt-2 flex justify-between gap-3">
            <button class="btn btn-neutral flex-grow" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>

            <x-button class="btn btn-error flex-grow"
                      type="submit" spinner="disableTwoFactor">
                {{ __('messages.buttons.disable') }}
            </x-button>
        </div>
    </x-form>
</x-modal>
