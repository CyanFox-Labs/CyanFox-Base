<div>
    <div class="ml-2 mb-5">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}"><i class="bx bxs-home mr-2"></i> Home</a></li>
                <li><img src="https://source.boringavatars.com/beam/120/{{ auth()->user()->username }}"
                         alt="Profile" class="h-7 w-7 rounded-3xl mr-2"> Profile
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
                    <span class="font-bold text-xl">Language & Theme</span>
                    <div class="divider"></div>
                    <div class="form-control w-full">
                        <label class="label" for="language">
                            <span class="label-text font-bold">Select Language</span>
                        </label>
                        <select class="select select-bordered" id="language"
                                wire:blur="changeLanguage($event.target.value)">
                            <option value="en" @if(auth()->user()->language == 'en') selected @endif>English</option>
                            <option value="de" @if(auth()->user()->language == 'de') selected @endif>German</option>
                        </select>
                    </div>
                    <div class="form-control w-full">
                        <label class="label" for="theme">
                            <span class="label-text font-bold">Select Theme</span>
                        </label>
                        <select class="select select-bordered" id="theme" wire:blur="changeTheme($event.target.value)">
                            <option value="light" @if(auth()->user()->theme == 'light') selected @endif>Light</option>
                            <option value="dark" @if(auth()->user()->theme == 'dark') selected @endif>Dark</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <span class="font-bold text-xl">Sessions</span>
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
                                    <button class="btn btn-ghost" onclick="logout.showModal()">Current</button>
                                @else
                                    <button class="btn btn-ghost text-warning"
                                            onclick="logout_session_{{ $session['id'] }}.showModal()">
                                        Revoke
                                    </button>
                                @endif
                            </div>

                            <dialog id="logout_session_{{ $session['id'] }}" class="modal">
                                <div class="modal-box">

                                    <div class="text-center">
                                        <h2 class="text-2xl font-bold mb-4">Log Session out?</h2>
                                        <p class="mb-3">Please enter your password to confirm you would like to log out
                                            the session.</p>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="form-control w-full max-w-xs">
                                            <label class="label" for="disable_two_factor_password">
                                                <span class="label-text">Password</span>
                                            </label>
                                            <input type="password" id="disable_two_factor_password"
                                                   wire:model="passwordLogoutSession.{{ $session['id'] }}"
                                                   class="input input-bordered w-full max-w-xs mb-4"/>
                                        </div>
                                    </div>
                                    <div class="flex justify-center modal-action">
                                        <form method="dialog">
                                            <button class="btn btn-neutral">Cancel</button>
                                            <button class="btn btn-success"
                                                    wire:click="logoutSession('{{ $session['id'] }}')">Yes
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                        @endforeach
                    </div>
                    <div class="divider"></div>
                    <button class="btn btn-error btn-outline w-1/3" onclick="logout_sessions.showModal()">
                        Logout Sessions
                    </button>
                </div>
            </div>
        </div>
        <div class="col-span-2 space-y-4">
            <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                <div class="card-body">
                    <form class="grid grid-cols-2 gap-4" onsubmit="event.preventDefault()">
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="first_name">
                                    <span class="label-text">First Name</span>
                                </label>
                                <input id="first_name" type="text"
                                       class="input input-bordered w-full" wire:model="first_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="last_name">
                                    <span class="label-text">Last Name</span>
                                </label>
                                <input id="last_name" type="text"
                                       class="input input-bordered w-full" wire:model="last_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="username">
                                    <span class="label-text">Username</span>
                                </label>
                                <input id="username" type="text"
                                       class="input input-bordered w-full" wire:model="username"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="email">
                                    <span class="label-text">E-Mail</span>
                                </label>
                                <input id="email" type="text"value="{{ auth()->user()->email }}"
                                       class="input input-bordered w-full" wire:model="email"/>
                            </div>
                        </div>
                        <div class="col-span-1 mt-6">
                            <button type="submit"
                                    class="btn btn-primary w-24" onclick="show_profile_infos.showModal()">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-span-2 space-y-4">
                <div class="card bg-base-100 col-span-1 lg:col-span-2 shadow-xl">
                    <div class="card-body">
                        <form class="" onsubmit="event.preventDefault()">
                            <div class="w-full">
                                <div class="form-control w-full">
                                    <label class="label" for="current_password">
                                        <span class="label-text">Current Password</span>
                                    </label>
                                    <input id="current_password" type="password"
                                           class="input input-bordered w-full" wire:model="current_password"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <div class="form-control w-full">
                                        <label class="label" for="new_password">
                                            <span class="label-text">New Password</span>
                                        </label>
                                        <input id="new_password" type="password"
                                               class="input input-bordered w-full" wire:model="new_password"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-control w-full">
                                        <label class="label" for="confirm_password">
                                            <span class="label-text">Confirm Password</span>
                                        </label>
                                        <input id="confirm_password" type="password"
                                               class="input input-bordered w-full" wire:model="confirm_password"/>
                                    </div>
                                </div>
                                <div class="col-span-1 mt-6 space-x-2 space-y-2">
                                    <button type="submit"
                                            class="btn btn-primary w-24" wire:click="updatePassword">
                                        Update
                                    </button>

                                    @if(auth()->user()->two_factor_enabled)
                                        <button type="submit"
                                                class="btn btn-error" onclick="disable_two_factor.showModal()">
                                            Disable 2FA
                                        </button>
                                        <button type="submit"
                                                class="btn btn-accent"
                                                onclick="show_two_factor_recovery_keys.showModal()">
                                            Show Recovery Codes
                                        </button>
                                    @else
                                        <button type="submit"
                                                class="btn btn-accent" onclick="activate_two_factor.showModal()">
                                            Enable 2FA
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

    <x-profile.update_profile_infos></x-profile.update_profile_infos>
    <x-profile.disable_2fa></x-profile.disable_2fa>
    <x-profile.logout></x-profile.logout>
    <x-profile.logout_all_sessions></x-profile.logout_all_sessions>
    <x-profile.activate_2fa twoFactorImage="{{ $twoFactorImage }}"></x-profile.activate_2fa>
    <x-profile.recovery_codes_password></x-profile.recovery_codes_password>
    <x-profile.recovery_codes></x-profile.recovery_codes>
</div>

