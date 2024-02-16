<div>
    <x-form wire:submit="registerUser">
        <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">
            <x-input label="{{ __('pages/installer.create_user.first_name') }}"
                     class="input input-bordered w-full"
                     wire:model="firstName" required/>

            <x-input label="{{ __('pages/installer.create_user.last_name') }}"
                     class="input input-bordered w-full"
                     wire:model="lastName" required/>


            <x-input label="{{ __('pages/auth/messages.username') }}"
                     class="input input-bordered w-full"
                     wire:model="username" required/>

            <x-input label="{{ __('pages/auth/messages.email') }}"
                     type="email"
                     class="input input-bordered w-full"
                     wire:model="email" required/>


            <x-input label="{{ __('pages/auth/messages.password') }}"
                     type="password"
                     class="input input-bordered w-full"
                     wire:model="password" required/>

            <x-input label="{{ __('pages/installer.create_user.password_confirmation') }}"
                     type="password"
                     class="input input-bordered w-full"
                     wire:model="passwordConfirmation" required/>
        </div>

        <div class="divider"></div>

        <div class="mt-2 flex justify-between gap-3">
            <x-button class="btn btn-neutral"
                      type="button" wire:click="$dispatch('changeStep', ['email'])" spinner>
                {{ __('pages/installer.buttons.back') }}
            </x-button>
            <x-button class="btn btn-success"
                      type="submit" spinner="registerUser">
                {{ __('pages/installer.buttons.finish') }}
            </x-button>
        </div>

    </x-form>
</div>
