<div>

    <div role="tablist" class="tabs tabs-bordered pb-4">
        <a role="tab" class="tab @if($tab == 'overview') tab-active @endif"
           wire:click="$set('tab', 'overview')"><i class="icon-home pr-2"></i>
            <span class="md:block hidden">{{ __('pages/account/profile.tabs.overview') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'sessions') tab-active @endif"
           wire:click="$set('tab', 'sessions')"><i class="icon-monitor-dot pr-2"></i>
            <span class="md:block hidden">{{ __('pages/account/profile.tabs.sessions') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'apiKeys') tab-active @endif"
           wire:click="$set('tab', 'apiKeys')"><i class="icon-key-round pr-2"></i>
            <span class="md:block hidden">{{ __('pages/account/profile.tabs.api_keys') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'activity') tab-active @endif"
           wire:click="$set('tab', 'activity')"><i class="icon-eye pr-2"></i>
            <span class="md:block hidden">{{ __('pages/account/profile.tabs.activity') }}</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        @if($tab == 'overview')
            <div class="col-span-1 space-y-4">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex">
                            @if(setting('profile_enable_change_avatar'))
                                <div class="h-16 w-16 relative mr-4 group">
                                    <div
                                        class="absolute inset-0 bg-cover bg-center z-0 rounded-3xl group-hover:opacity-70 transition-opacity duration-300"
                                        style="background-image: url('{{ auth()->user()->getAvatarURL() }}')"></div>
                                    <div
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.upload-profile-image' })"
                                        class="opacity-0 group-hover:opacity-100 hover:cursor-pointer duration-300 absolute inset-0 z-10 flex justify-center items-center text-3xl text-white font-semibold">
                                        <i class="icon-upload"></i></div>
                                </div>
                            @else
                                <img src="{{ auth()->user()->getAvatarURL() }}"
                                     alt="Profile" class="h-16 w-16 rounded-3xl mr-4">
                            @endif
                            <div>
                                <p class="font-bold">{{ auth()->user()->username }}</p>
                                <p class="dark:text-gray-300 text-gray-600">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                <div class="divider"></div>
                                <p class="dark:text-gray-300 text-gray-600">{{ auth()->user()->getRoleNames()->implode(', ') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <span
                            class="font-bold text-xl">{{ __('pages/account/profile.language_and_theme.title') }}</span>
                        <div class="divider"></div>

                        <x-select label="{{ __('pages/account/profile.language_and_theme.select_language') }}"
                                  wire:model="language"
                                  class="select select-bordered"
                                  :options="
                                      [['id' => 'en', 'name' => __('messages.languages.english')],
                                      ['id' => 'de', 'name' => __('messages.languages.german')]]"></x-select>

                        <x-select label="{{ __('pages/account/profile.language_and_theme.select_theme') }}"
                                  wire:model="theme"
                                  class="select select-bordered"
                                  :options="$themes"></x-select>

                        <div class="divider"></div>
                        <div class="flex justify-start">
                            <x-button type="submit"
                                      wire:click="updateLanguageAndTheme"
                                      class="btn btn-primary" spinner>
                                {{ __('messages.buttons.update') }}
                            </x-button>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <span
                            class="font-bold text-xl">{{ __('pages/account/profile.actions.title') }}</span>
                        <div class="divider"></div>
                        <div class="grid sm:grid-cols-2 grid-cols-1 gap-2">

                            @if(auth()->user()->two_factor_enabled)
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.recovery-codes' })"
                                        class="btn btn-accent">
                                    {{ __('pages/account/profile.actions.buttons.show_recovery_codes') }}
                                </button>
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.disable-two-factor' })"
                                        class="btn btn-error">
                                    {{ __('pages/account/profile.actions.buttons.disable_two_factor') }}
                                </button>
                            @else
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.activate-two-factor' })"
                                        class="btn btn-success">
                                    {{ __('pages/account/profile.actions.buttons.activate_two_factor') }}
                                </button>
                            @endif

                            @if(auth()->user()->password == null)

                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.set-password' })"
                                        class="btn btn-success">
                                    {{ __('pages/account/profile.actions.buttons.set_password') }}
                                </button>

                            @endif

                            @if(setting('enable_delete_account') && auth()->user()->password !== null)
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.delete-account' })"
                                        class="btn btn-error">
                                    {{ __('pages/account/profile.actions.buttons.delete_account') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 space-y-4">
                <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                    <div class="card-body">
                        <x-form wire:submit="updateProfileInformations">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('pages/account/profile.account_details.first_name') }}"
                                                 class="input input-bordered w-full" wire:model="firstName"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('pages/account/profile.account_details.last_name') }}"
                                                 class="input input-bordered w-full" wire:model="lastName"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('pages/account/profile.account_details.username') }}"
                                                 class="input input-bordered w-full" wire:model="username"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('pages/account/profile.account_details.email') }}"
                                                 type="email"
                                                 class="input input-bordered w-full" wire:model="email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="col-span-1 flex gap-2 sm:flex-row flex-col">
                                <x-button type="submit"
                                          class="btn btn-primary" spinner="updateProfileInformations">
                                    {{ __('messages.buttons.update') }}
                                </x-button>
                            </div>
                        </x-form>
                    </div>
                </div>
                @if(auth()->user()->password !== null)
                    <div class="col-span-2 space-y-4">
                        <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                            <div class="card-body">
                                <x-form wire:submit="updatePassword">
                                    <div class="w-full">
                                        <div class="form-control w-full">
                                            <x-input label="{{ __('pages/account/profile.account_details.current_password') }}"
                                                     type="password"
                                                     class="input input-bordered w-full" wire:model="currentPassword"/>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <div class="form-control w-full">
                                                <x-input label="{{ __('pages/account/profile.account_details.new_password') }}"
                                                         type="password"
                                                         class="input input-bordered w-full" wire:model="newPassword"/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-control w-full">
                                                <x-input label="{{ __('pages/account/profile.account_details.confirm_new_password') }}"
                                                         type="password"
                                                         class="input input-bordered w-full"
                                                         wire:model="passwordConfirmation"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="col-span-1 flex gap-2 sm:flex-row flex-col">
                                        <x-button type="submit" class="btn btn-primary" spinner="updatePassword">
                                            {{ __('messages.buttons.update') }}
                                        </x-button>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

</div>
