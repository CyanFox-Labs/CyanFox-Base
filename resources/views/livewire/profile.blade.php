<div>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i class="bx bxs-home mr-2"></i> {{ __('breadcrumbs.home') }}</a></li>
                <li><img src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}"
                         alt="Profile" class="h-7 w-7 rounded-3xl mr-2"> {{ __('breadcrumbs.profile') }}
                </li>
            </ul>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="col-span-1 space-y-4">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex">
                        <img src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}"
                             alt="Profile" class="h-16 w-16 rounded-3xl mr-4">
                        <div>
                            <p class="font-bold">{{ auth()->user()->username }}</p>
                            <p>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <span class="font-bold text-xl">{{ __('pages/profile.language_theme') }}</span>
                    <div class="divider"></div>
                    <div class="form-control w-full">
                        <label class="label" for="language">
                            <span class="label-text font-bold">{{ __('pages/profile.select_language') }}</span>
                        </label>
                        <select class="select select-bordered" id="language"
                                wire:blur="changeLanguage($event.target.value)">
                            <option value="de" @if(auth()->user()->language == 'de') selected @endif>{{ __('messages.languageType.de') }}</option>
                            <option value="en" @if(auth()->user()->language == 'en') selected @endif>{{ __('messages.languageType.en') }}</option>
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label" for="theme">
                            <span class="label-text font-bold">{{ __('pages/profile.select_theme') }}</span>
                        </label>
                        <select class="select select-bordered" id="theme" wire:blur="changeTheme($event.target.value)">
                            <option value="light" @if(auth()->user()->theme == 'light') selected @endif>{{ __('pages/profile.themeType.light') }}</option>
                            <option value="dark" @if(auth()->user()->theme == 'dark') selected @endif>{{ __('pages/profile.themeType.dark') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <span class="font-bold text-xl">{{ __('pages/profile.sessions') }}</span>
                    <div class="divider"></div>
                    <div class="grid grid-cols-4 items-center gap-x-4 overflow-x-auto">
                        @foreach ($sessionData as $session)
                            <div class="col-span-3 flex items-center space-x-2 space-y-3">
                                <div class="text-4xl">
                                    @if($session['deviceType'] == 'Desktop')
                                        <i class="bx bx-desktop"></i>
                                    @elseif($session['deviceType'] == 'Phone')
                                        <i class="bx bx-mobile-alt"></i>
                                    @elseif($session['deviceType'] == 'Tablet')
                                        <i class="bx bx-tab"></i>
                                    @else
                                        <i class="bx bx-devices"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold">{{ $session['ip'] }}</div>
                                    <div>{{ $session['platform'] }}</div>
                                </div>
                            </div>
                            <div class="col-span-1 text-end">
                                @if ($session['isCurrentSession'])
                                    <button class="btn btn-ghost" onclick="logout.showModal()">{{ __('pages/profile.current_session') }}</button>
                                @else
                                    <dialog id="logout_session_{{ $session['id'] }}" class="modal modal-bottom sm:modal-middle">
                                        <div class="modal-box">

                                            <div class="text-center">
                                                <h2 class="text-2xl font-bold mb-4">{{ __('pages/profile.modal.logout_specific.title') }}</h2>
                                                <p class="mb-3">{{ __('pages/profile.modal.logout_specific.description') }}</p>
                                            </div>
                                            <div class="flex justify-center">
                                                <div class="form-control w-full max-w-xs">
                                                    <label class="label" for="logout_session_{{ $session['id'] }}">
                                                        <span class="label-text">{{ __('messages.password') }}</span>
                                                    </label>
                                                    <input type="password" id="logout_session_{{ $session['id'] }}"
                                                           wire:model="passwordLogoutSession.{{ $session['id'] }}"
                                                           class="input input-bordered w-full max-w-xs mb-4"/>
                                                </div>
                                            </div>
                                            <div class="flex justify-center modal-action">
                                                <form method="dialog">
                                                    <button class="btn btn-neutral">{{ __('messages.cancel') }}</button>
                                                    <button class="btn btn-success"
                                                            wire:click="logoutSession('{{ $session['id'] }}')">{{ __('pages/profile.modal.logout.logout') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </dialog>

                                    <button class="btn btn-ghost text-warning"
                                            onclick="document.getElementById('logout_session_{{ $session['id'] }}').showModal()">
                                        {{ __('pages/profile.revoke_session') }}
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="divider"></div>
                    <button class="btn btn-error btn-outline" onclick="logout_all_sessions.showModal()">
                        {{ __('pages/profile.logout_sessions') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-span-2 space-y-4">
            <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                <div class="card-body">
                    <form class="grid grid-cols-2 gap-4" wire:submit="updateProfile">
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="first_name">
                                    <span class="label-text">{{ __('pages/profile.first_name') }}</span>
                                </label>
                                <input id="first_name" type="text"
                                       class="input input-bordered w-full" wire:model="first_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="last_name">
                                    <span class="label-text">{{ __('pages/profile.last_name') }}</span>
                                </label>
                                <input id="last_name" type="text"
                                       class="input input-bordered w-full" wire:model="last_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="username">
                                    <span class="label-text">{{ __('pages/profile.username') }}</span>
                                </label>
                                <input id="username" type="text"
                                       class="input input-bordered w-full" wire:model="username"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="email">
                                    <span class="label-text">{{ __('pages/profile.email') }}</span>
                                </label>
                                <input id="email" type="text"
                                       class="input input-bordered w-full" wire:model="email"/>
                            </div>
                        </div>
                        <div class="col-span-1 mt-6">
                            <button type="submit"
                                    class="btn btn-primary">
                                {{ __('messages.update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-span-2 space-y-4">
                <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                    <div class="card-body">
                        <form onclick="event.preventDefault()">
                            <div class="w-full">
                                <div class="form-control w-full">
                                    <label class="label" for="current_password">
                                        <span class="label-text">{{ __('pages/profile.current_password') }}</span>
                                    </label>
                                    <input id="current_password" type="password"
                                           class="input input-bordered w-full" wire:model="current_password"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <div class="form-control w-full">
                                        <label class="label" for="new_password">
                                            <span class="label-text">{{ __('pages/profile.new_password') }}</span>
                                        </label>
                                        <input id="new_password" type="password"
                                               class="input input-bordered w-full" wire:model="new_password"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <label class="label" for="confirm_password">
                                            <span class="label-text">{{ __('pages/profile.confirm_password') }}</span>
                                        </label>
                                        <input id="confirm_password" type="password"
                                               class="input input-bordered w-full" wire:model="confirm_password"/>
                                    </div>
                                </div>
                                <div class="col-span-1 mt-6 space-y-2">
                                    <button type="submit" wire:click="updatePassword"
                                            class="btn btn-primary">
                                        {{ __('messages.update') }}
                                    </button>

                                    @if(auth()->user()->two_factor_enabled)
                                        <button type="button"
                                                class="btn btn-error" onclick="disable_two_factor.showModal()">
                                            {{ __('pages/profile.disable_2fa') }}
                                        </button>
                                        <button type="button"
                                                class="btn btn-accent"
                                                onclick="show_two_factor_recovery_codes.showModal()">
                                            {{ __('pages/profile.show_recovery_codes') }}
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-accent" onclick="activate_two_factor.showModal()">
                                            {{ __('pages/profile.enable_2fa') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @livewire('components.modals.profile.activate-two-factor')
    @livewire('components.modals.profile.disable-two-factor')
    @livewire('components.modals.profile.logout')
    @livewire('components.modals.profile.logout-all-sessions')
    @livewire('components.modals.profile.recovery-codes')
</div>

