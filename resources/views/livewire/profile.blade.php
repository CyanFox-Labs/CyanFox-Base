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
                                <input id="first_name" type="text" value="{{ auth()->user()->first_name }}"
                                       class="input input-bordered w-full" wire:model="first_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="last_name">
                                    <span class="label-text">Last Name</span>
                                </label>
                                <input id="last_name" type="text" value="{{ auth()->user()->last_name }}"
                                       class="input input-bordered w-full" wire:model="last_name"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="username">
                                    <span class="label-text">Username</span>
                                </label>
                                <input id="username" type="text" value="{{ auth()->user()->username }}"
                                       class="input input-bordered w-full" wire:model="username"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="email">
                                    <span class="label-text">E-Mail</span>
                                </label>
                                <input id="email" type="text" value="{{ auth()->user()->email }}"
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
                                                class="btn btn-accent" onclick="show_two_factor_recovery_keys.showModal()">
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

    <dialog id="show_profile_infos" class="modal">
        <div class="modal-box">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Update Profile Information?</h2>
                <p class="mb-3">Please enter your password to confirm you would like to update your Profile Information.</p>

                <div class="flex justify-center">
                    <div class="form-control w-full max-w-xs">
                        <label class="label" for="logout_sessions_password">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="logout_sessions_password"
                               class="input input-bordered w-full max-w-xs mb-4"
                               wire:model="passwords.updateProfileInfos"/>
                    </div>
                </div>
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Cancel</button>
                    <button class="btn btn-success" wire:click="updateProfileInfos">Update</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="disable_two_factor" class="modal">
        <div class="modal-box">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Disable Two-Factor</h2>
                <p class="mb-3">To disable Two-Factor, please enter your password </p>

                <div class="flex justify-center">
                    <div class="form-control w-full max-w-xs">
                        <label class="label" for="disable_two_factor_password">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="disable_two_factor_password"
                               class="input input-bordered w-full max-w-xs mb-4"
                               wire:model="passwords.disable2fa"/>
                    </div>
                </div>
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Cancel</button>
                    <button class="btn btn-success" wire:click="disableTwoFactor">Disable Two-Factor</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="logout" class="modal">
        <div class="modal-box">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Logout?</h2>
                <p class="mb-3">You clicked on your own session. Do you want to log out?</p>
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Cancel</button>
                    <a href="{{ route('logout') }}" role="button" class="btn btn-success">Yes</a>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="logout_sessions" class="modal">
        <div class="modal-box">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Logout other Sessions?</h2>
                <p class="mb-3">Please enter your password to confirm you would like to log out other sessions.</p>

                <div class="flex justify-center">
                    <div class="form-control w-full max-w-xs">
                        <label class="label" for="logout_sessions_password">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="logout_sessions_password"
                               class="input input-bordered w-full max-w-xs mb-4"
                               wire:model="passwords.logoutAllSessions"/>
                    </div>
                </div>
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Cancel</button>
                    <button class="btn btn-success" wire:click="logoutAllSessions">Logout other Sessions</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="activate_two_factor" class="modal">
        <div class="modal-box">

            <div class="flex justify-center">

                <img src="data:image/svg+xml;base64,{{ $twoFactorImage }}" alt="Two Factor Image"
                     class="border-4 border-white mr-6">

                <div class="space-y-4">
                    <div class="form-control w-full max-w-xs">
                        <label class="label" for="two_factor_key">
                            <span class="label-text">Two-Factor Key</span>
                        </label>
                        <input type="number" id="two_factor_key" class="input input-bordered w-full max-w-xs"
                               wire:model="two_factor_key"/>
                    </div>

                    <div class="form-control w-full max-w-xs">
                        <label class="label" for="two_factor_password">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="two_factor_password" class="input input-bordered w-full max-w-xs"
                               wire:model="passwords.enable2fa"/>
                    </div>
                </div>

            </div>


            <div class="modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Cancel</button>
                    <button class="btn btn-success" wire:click="activateTwoFactor">Activate Two-Factor</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="show_two_factor_recovery_keys" class="modal">
        <div class="modal-box">

            <div class="text-center">
                <h2 class="text-2xl font-bold mb-4">Show 2FA Recovery Keys</h2>
                <p class="mb-3">Please enter your password to see the 2FA Recovery Keys</p>

                <div class="flex justify-center">
                    <div class="form-control w-full max-w-xs">
                        <label class="label" for="logout_sessions_password">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" id="logout_sessions_password"
                               class="input input-bordered w-full max-w-xs mb-4"
                               wire:model="passwords.showRecoveryKeys"/>
                    </div>
                </div>
            </div>
            <div class="flex justify-center modal-action">
                <form method="dialog" class="space-x-2">
                    <button class="btn btn-neutral">Cancel</button>
                    <button class="btn btn-success" wire:click="showRecoveryKeys">Show Recovery Keys</button>
                </form>
            </div>
        </div>
    </dialog>

    @if(session()->has('recovery_codes'))
        <dialog id="recovery_codes" class="modal">
            <div class="modal-box">

                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">2FA Recovery Keys</h2>

                        @foreach(session('recovery_codes') as $recovery_code)
                            <p class="mb-3">{{ $recovery_code }}</p>
                        @endforeach
                </div>
                <div class="flex justify-center modal-action">
                    <form method="dialog" class="space-x-2">
                        <button class="btn btn-neutral">Close</button>
                    </form>
                </div>
            </div>
        </dialog>
        <script>
            recovery_codes.showModal();
        </script>
    @endif
</div>

