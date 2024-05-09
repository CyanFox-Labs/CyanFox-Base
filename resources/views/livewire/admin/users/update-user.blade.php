<div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <span class="font-bold text-xl">{{ __('admin/users.update.title', ['user' => $user->username]) }}</span>
            <div class="divider"></div>

            <x-form wire:submit="updateUser">
                @csrf

                <div class="grid md:grid-cols-2 gap-4 mt-4">
                    <x-input label="{{ __('messages.first_name') }}"
                             class="input input-bordered w-full" wire:model="firstName" required/>

                    <x-input label="{{ __('messages.last_name') }}"
                             class="input input-bordered w-full" wire:model="lastName" required/>

                    <x-input label="{{ __('messages.username') }}"
                             class="input input-bordered w-full" wire:model="username" required/>

                    <x-input label="{{ __('messages.email') }}" type="email"
                             class="input input-bordered w-full" wire:model="email" required/>

                    <x-input label="{{ __('messages.password') }}" type="password"
                             class="input input-bordered w-full" wire:model="password"/>

                    <x-input label="{{ __('messages.confirm_password') }}" type="password"
                             class="input input-bordered w-full" wire:model="passwordConfirmation"/>

                    <x-custom.multi-select label="{{ __('admin/users.groups') }}"
                                           wire:model="selectedGroups" :selected="$selectedGroups" :options="$groups"/>
                    <x-custom.multi-select label="{{ __('admin/users.permissions') }}"
                                           wire:model="selectedPermissions" :selected="$selectedPermissions"
                                           :options="$permissions"/>

                    <div class="space-y-4">
                        <x-checkbox label="{{ __('admin/users.force_activate_two_factor') }}"
                                    wire:model="forceActivateTwoFactor" class="checkbox-info" left tight/>

                        <x-checkbox label="{{ __('admin/users.force_change_password') }}"
                                    wire:model="forceChangePassword" class="checkbox-info" left tight/>

                        <x-checkbox label="{{ __('admin/users.disabled') }}"
                                    wire:model="disabled" class="checkbox-info" left tight/>
                    </div>

                </div>

                <div class="divider mt-4"></div>

                <div class="mt-2 flex justify-start gap-3">
                    <a class="btn btn-neutral" type="button"
                       href="{{ route('admin.users') }}" wire:navigate>{{ __('messages.buttons.back') }}</a>

                    <x-button class="btn btn-success"
                              type="submit" spinner="updateUser">
                        {{ __('admin/users.update.buttons.update_user') }}
                    </x-button>
                </div>
            </x-form>
        </div>
    </div>

</div>
