<div>
    @if(session()->has('recovery_codes'))
        <x-custom.modal name="recovery_codes">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modal.recovery_codes.title') }}</h2>
                <p class="mb-3">{{ __('pages/profile.modal.recovery_codes.description') }}</p>

                @foreach(session('recovery_codes') as $recovery_code)
                    <p class="mb-3">{{ $recovery_code }}</p>
                @endforeach
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">{{ __('messages.close') }}</button>
                    <button class="btn btn-accent"
                            wire:click="download">{{ __('pages/profile.modal.recovery_codes.save') }}</button>
                </form>
            </div>
        </x-custom.modal>
        <script>
            document.getElementById('recovery_codes').showModal();
        </script>
    @endif
    <x-custom.modal name="show_two_factor_recovery_codes">

        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modal.recovery_codes_password.title') }}</h2>
            <p class="mb-3">{{ __('pages/profile.modal.recovery_codes_password.description') }}</p>

            <div class="flex justify-center">
                <div class="form-control w-full max-w-xs">
                    <label class="label" for="show_two_factor_recovery_codes_password">
                        <span class="label-text">{{ __('messages.password') }}</span>
                    </label>
                    <input type="password" id="show_two_factor_recovery_codes_password"
                           class="input input-bordered w-full max-w-xs mb-4"
                           wire:model="password"/>
                </div>
            </div>
        </div>
        <div class="flex justify-center modal-action">
            <form method="dialog">
                <button class="btn btn-neutral">{{ __('messages.cancel') }}</button>
                <button class="btn btn-success"
                        wire:click="showRecoveryKeys">{{ __('pages/profile.modal.recovery_codes_password.show') }}</button>
            </form>
        </div>
    </x-custom.modal>

</div>
