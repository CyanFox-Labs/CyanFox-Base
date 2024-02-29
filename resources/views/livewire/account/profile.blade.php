<div>

    <div role="tablist" class="tabs tabs-boxed mb-4">
        <a role="tab" class="tab @if($tab == 'overview') tab-active @endif"
           wire:click="$set('tab', 'overview')"><i class="icon-home pr-2"></i>
            <span class="md:block hidden">{{ __('account/profile.tabs.overview') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'sessions') tab-active @endif"
           wire:click="$set('tab', 'sessions')"><i class="icon-monitor-dot pr-2"></i>
            <span class="md:block hidden">{{ __('account/profile.tabs.sessions') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'apiKeys') tab-active @endif"
           wire:click="$set('tab', 'apiKeys')"><i class="icon-key-round pr-2"></i>
            <span class="md:block hidden">{{ __('account/profile.tabs.api_keys') }}</span>
        </a>

        <a role="tab" class="tab @if($tab == 'activity') tab-active @endif"
           wire:click="$set('tab', 'activity')"><i class="icon-eye pr-2"></i>
            <span class="md:block hidden">{{ __('account/profile.tabs.activity') }}</span>
        </a>
    </div>

    @if($tab == 'overview')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="col-span-1 space-y-4">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex">
                            @if(setting('profile_enable_change_avatar'))
                                <div class="h-16 w-16 relative mr-4 group">
                                    <div
                                        class="absolute inset-0 bg-cover bg-center z-0 rounded-3xl group-hover:opacity-70 transition-opacity duration-300"
                                        style="background-image: url('{{ user()->getUser(auth()->user())->getAvatarURL() }}')"></div>
                                    <div
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.change-avatar' })"
                                        class="opacity-0 group-hover:opacity-100 hover:cursor-pointer duration-300 absolute inset-0 z-10 flex justify-center items-center text-3xl text-white font-semibold">
                                        <i class="icon-upload"></i></div>
                                </div>
                            @else
                                <img src="{{ user()->getUser(auth()->user())->getAvatarURL() }}"
                                     alt="Avatar" class="h-16 w-16 rounded-3xl mr-4">
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
                            class="font-bold text-xl">{{ __('account/profile.language_and_theme.title') }}</span>
                        <div class="divider"></div>

                        <x-select label="{{ __('account/profile.language_and_theme.select_language') }}"
                                  wire:model="language"
                                  class="select select-bordered"
                                  :options="
                                      [['id' => 'en', 'name' => __('messages.languages.en')],
                                      ['id' => 'de', 'name' => __('messages.languages.de')]]"></x-select>

                        <x-select label="{{ __('account/profile.language_and_theme.select_theme') }}"
                                  wire:model="theme"
                                  class="select select-bordered"
                                  :options="$themes"></x-select>

                        <div class="divider"></div>
                        <div class="flex justify-start">
                            <x-button type="submit"
                                      wire:click="updateLanguageAndTheme"
                                      class="btn btn-primary" spinner>
                                {{ __('account/profile.buttons.update_profile') }}
                            </x-button>
                        </div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <span
                            class="font-bold text-xl">{{ __('account/profile.actions.title') }}</span>
                        <div class="divider"></div>
                        <div class="grid sm:grid-cols-2 grid-cols-1 gap-2">

                            @if(auth()->user()->two_factor_enabled)
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.two-factor.show-recovery-codes' })"
                                        class="btn btn-accent">
                                    {{ __('account/profile.actions.buttons.show_recovery_codes') }}
                                </button>
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.two-factor.disable-two-factor' })"
                                        class="btn btn-error">
                                    {{ __('account/profile.actions.buttons.disable_two_factor') }}
                                </button>
                            @elseif(!auth()->user()->password == null)
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.two-factor.activate-two-factor' })"
                                        class="btn btn-success">
                                    {{ __('account/profile.actions.buttons.activate_two_factor') }}
                                </button>
                            @endif

                            @if(auth()->user()->password == null)

                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.setup-password' })"
                                        class="btn btn-success">
                                    {{ __('account/profile.actions.buttons.setup_password') }}
                                </button>

                            @endif

                            @if(setting('profile_enable_delete_account') && !auth()->user()->password == null)
                                <button type="button"
                                        wire:click="$dispatch('openModal', { component: 'components.modals.account.delete-account' })"
                                        class="btn btn-error">
                                    {{ __('account/profile.actions.buttons.delete_account') }}
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
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('messages.first_name') }}"
                                                 class="input input-bordered w-full" wire:model="firstName"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('messages.last_name') }}"
                                                 class="input input-bordered w-full" wire:model="lastName"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('messages.username') }}"
                                                 class="input input-bordered w-full" wire:model="username"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <x-input label="{{ __('messages.email') }}"
                                                 type="email"
                                                 class="input input-bordered w-full" wire:model="email"/>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="col-span-1 flex gap-2 sm:flex-row flex-col">
                                <x-button type="submit"
                                          class="btn btn-primary" spinner="updateProfileInformations">
                                    {{ __('account/profile.buttons.update_profile') }}
                                </x-button>
                            </div>
                        </x-form>
                    </div>
                </div>
                @if(!auth()->user()->password == null)
                    <div class="col-span-2 space-y-4">
                        <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                            <div class="card-body">
                                <x-form wire:submit="updatePassword">
                                    @csrf
                                    <div class="w-full">
                                        <div class="form-control w-full">
                                            <x-input
                                                label="{{ __('messages.current_password') }}"
                                                type="password"
                                                class="input input-bordered w-full" wire:model="currentPassword"/>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <div class="form-control w-full">
                                                <x-input
                                                    label="{{ __('messages.new_password') }}"
                                                    type="password"
                                                    class="input input-bordered w-full" wire:model="newPassword"/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-control w-full">
                                                <x-input
                                                    label="{{ __('messages.confirm_password') }}"
                                                    type="password"
                                                    class="input input-bordered w-full"
                                                    wire:model="passwordConfirmation"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="col-span-1 flex gap-2 sm:flex-row flex-col">
                                        <x-button type="submit" class="btn btn-primary" spinner="updatePassword">
                                            {{ __('account/profile.buttons.update_profile') }}
                                        </x-button>
                                    </div>
                                </x-form>
                            </div>
                        </div>
                    </div>
                @endif


                @forelse (app('integrate.views')->getAll() as $moduleComponent)
                    @if($moduleComponent['section'] == 'overview' && $moduleComponent['location'] == 'account.profile')
                        @component($moduleComponent['component'])
                        @endcomponent
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    @endif



    @if($tab == 'sessions')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <span class="font-bold text-xl">{{ __('account/profile.sessions.title') }}</span>
                <div class="divider"></div>
                <livewire:components.tables.account.sessions-table/>
            </div>
        </div>
    @endif

    @if($tab == 'apiKeys')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <span class="font-bold text-xl">{{ __('account/profile.api_keys.title') }}</span>
                <div class="divider"></div>
                <livewire:components.tables.account.a-p-i-keys-table/>
            </div>
        </div>
    @endif

    @if($tab == 'activity')
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <span class="font-bold text-xl">{{ __('account/profile.activity.title') }}</span>
                <div class="divider"></div>
                <livewire:components.tables.account.activity-table/>
            </div>
        </div>
    @endif

</div>
