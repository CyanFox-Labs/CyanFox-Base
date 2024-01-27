<div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <span class="font-bold text-xl">{{ __('pages/admin/users/update_user.title', ['user' => $user->username]) }}</span>
            <div class="divider"></div>

            <x-form wire:submit="updateUser">
                @csrf

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <x-input label="{{ __('pages/admin/users/messages.first_name') }}"
                             class="input input-bordered w-full" wire:model="firstName" required/>

                    <x-input label="{{ __('pages/admin/users/messages.last_name') }}"
                             class="input input-bordered w-full" wire:model="lastName" required/>

                    <x-input label="{{ __('pages/admin/users/messages.username') }}"
                             class="input input-bordered w-full" wire:model="username" required/>

                    <x-input label="{{ __('pages/admin/users/messages.email') }}" type="email"
                             class="input input-bordered w-full" wire:model="email" required/>

                    <x-input label="{{ __('pages/admin/users/messages.password') }}" type="password"
                             class="input input-bordered w-full" wire:model="password"/>

                    <x-input label="{{ __('pages/admin/users/messages.password_confirmation') }}" type="password"
                             class="input input-bordered w-full" wire:model="passwordConfirmation"/>

                    <x-custom.multi-select label="{{ __('pages/admin/users/messages.groups') }}"
                                           wire:model="selectedGroups" :selected="$selectedGroups" :options="$groups"/>
                    <x-custom.multi-select label="{{ __('pages/admin/users/messages.permissions') }}"
                                           wire:model="selectedPermissions" :selected="$selectedPermissions" :options="$permissions"/>

                    <div class="space-y-4">
                        <x-checkbox label="{{ __('pages/admin/users/messages.force_activate_two_factor') }}"
                                    wire:model="forceActivateTwoFactor" class="checkbox-info" left tight/>

                        <x-checkbox label="{{ __('pages/admin/users/messages.force_change_password') }}"
                                    wire:model="forceChangePassword" class="checkbox-info" left tight/>

                        <x-checkbox label="{{ __('pages/admin/users/messages.disable') }}"
                                    wire:model="disabled" class="checkbox-info" left tight/>
                    </div>

                </div>

                <div class="divider mt-4"></div>

                <div class="mt-2 flex justify-start gap-3">
                    <a class="btn btn-neutral" type="button"
                       href="{{ route('admin.users') }}">{{ __('messages.buttons.back') }}</a>

                    <x-button class="btn btn-success"
                              type="submit" spinner="updateUser">
                        {{ __('messages.buttons.update') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>

</div>
