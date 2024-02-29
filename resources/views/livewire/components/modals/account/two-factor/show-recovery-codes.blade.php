<x-modal class="modal-bottom sm:modal-middle">

    @if($recoveryCodes == null)
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('account/profile.modals.show_recovery_codes.auth.title') }}</h2>
            <p class="mb-3">{{ __('account/profile.modals.show_recovery_codes.auth.description') }}</p>
        </div>

        <x-form wire:submit="showRecoveryCodes">
            @csrf
            <div class="flex justify-center mb-3">
                <div class="form-control w-full max-w-xs">
                    <x-input label="{{ __('messages.password') }}"
                             type="password"
                             class="input input-bordered w-full max-w-xs mb-4"
                             wire:model="password" required/>
                </div>
            </div>

            <div class="divider"></div>

            <div class="mt-2 flex justify-between gap-3">
                <button class="btn btn-neutral flex-grow" type="button"
                        wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>
                <x-button class="btn btn-success flex-grow"
                          type="submit"
                          spinner="showRecoveryKeys">{{ __('account/profile.modals.show_recovery_codes.auth.buttons.show_recovery_codes') }}</x-button>
            </div>
        </x-form>
    @else
        <div class="text-center mb-3">
            <h2 class="text-2xl font-bold mb-4">{{ __('account/profile.modals.show_recovery_codes.title') }}</h2>
            <p class="mb-3">{{ __('account/profile.modals.show_recovery_codes.description') }}</p>

            @foreach($recoveryCodes as $recoveryCode)
                <p class="mb-3">{{ $recoveryCode }}</p>
            @endforeach
        </div>


        <div class="divider"></div>

        <div class="mt-2 flex justify-between gap-3">

            <button class="btn btn-neutral flex-grow"
                    type="button"
                    wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>
            <x-button class="btn btn-warning flex-grow"
                      type="button" wire:click="regenerateRecoveryCodes"
                      spinner>{{ __('account/profile.modals.show_recovery_codes.buttons.regenerate_recovery_codes') }}</x-button>
            <x-button class="btn btn-success flex-grow"
                      type="button"
                      wire:click="downloadRecoveryCodes"
                      spinner>{{ __('account/profile.modals.show_recovery_codes.buttons.download_recovery_codes') }}</x-button>
        </div>
    @endif
</x-modal>
