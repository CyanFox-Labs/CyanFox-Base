<x-modal class="modal-bottom sm:modal-middle">

    <div class="flex justify-center">

        <div class="flex flex-col items-center mr-4">
            <img src="data:image/svg+xml;base64,{{ $twoFactorImage }}" alt="Two Factor Image"
                 class="border-4 border-white mb-2">
            <p>{{ $twoFactorSecret }}</p>
        </div>

        <div class="space-y-4">
            <div class="form-control w-full max-w-xs">
                <x-input label="{{ __('messages.two_factor_code') }}"
                         type="number" class="input input-bordered w-full max-w-xs"
                         wire:model="two_factor_key"/>
            </div>

            <div class="form-control w-full max-w-xs">
                <x-input label="{{ __('messages.password') }}"
                         type="password" class="input input-bordered w-full max-w-xs"
                         wire:model="password"/>
            </div>
        </div>

    </div>


    <div class="modal-action">
        <form method="dialog" class="flex gap-2" wire:submit="activateTwoFactor">
            <button class="btn btn-neutral" type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
            <x-button class="btn btn-success"
                      type="submit" spinner="activateTwoFactor">
                {{ __('pages/account/messages.buttons.activate_two_factor') }}
            </x-button>
        </form>
    </div>
</x-modal>
