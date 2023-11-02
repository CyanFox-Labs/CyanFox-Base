<div>
    <x-modal class="modal-bottom sm:modal-middle">

        <div class="text-center">
            @if($recovery_codes == null)
                <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.recovery_codes.password.title') }}</h2>
                <p class="mb-3">{{ __('pages/account/modals.recovery_codes.password.description') }}</p>

                <div class="flex justify-center">
                    <div class="form-control w-full max-w-xs">
                        <x-input label="{{ __('messages.password') }}"
                                 type="password"
                                 class="input input-bordered w-full max-w-xs mb-4"
                                 wire:model="password"/>
                    </div>
                </div>

                <div class="flex justify-center modal-action">
                    <form method="dialog" class="flex gap-2" wire:submit="showRecoveryKeys">
                        <button class="btn btn-neutral" type="button"
                                wire:click="$dispatch('closeModal')">{{ __('messages.cancel') }}</button>
                        <x-button class="btn btn-success"
                                  type="submit"
                                  spinner="showRecoveryKeys">{{ __('pages/account/modals.recovery_codes.password.buttons.show_recovery_codes') }}</x-button>
                    </form>
                </div>
            @else
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">{{ __('pages/account/modals.recovery_codes.title') }}</h2>
                    <p class="mb-3">{{ __('pages/account/modals.recovery_codes.description') }}</p>

                    @foreach($recovery_codes as $recovery_code)
                        <p class="mb-3">{{ $recovery_code }}</p>
                    @endforeach
                </div>
                <div class="flex justify-center modal-action">
                    <form method="dialog" class="space-x-2" wire:submit="download">
                        <button class="btn btn-neutral" type="button"
                                wire:click="$dispatch('closeModal')">{{ __('messages.close') }}</button>
                        <x-button class="btn btn-accent"
                                type="submit" spinner="download">{{ __('messages.save') }}</x-button>
                    </form>
                </div>
            @endif
        </div>
    </x-modal>
</div>
