<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col md:justify-center md:items-center">
        <p class="flex items-center justify-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32" src="{{ asset("img/Logo.svg") }}" alt="Logo">
            <span
                    class="text-4xl font-bold brand-text text-white lg:block hidden">{{ setting('app_name') }}</span>
        </p>
        <div
                class="card bg-base-200 @if(setting('auth_enable_oauth')) lg:w-1/3 @else lg:w-1/4 @endif sm:min-w-96 sm:w-1/8 w-auto">
            <div class="card-body">
                <div class="flex justify-end">
                    <label>
                        <select class="select select-bordered" wire:blur="changeLanguage($event.target.value)"
                                wire:model="language">
                            <option value="en">{{ __('messages.languages.en') }}</option>
                            <option value="de">{{ __('messages.languages.de') }}</option>
                        </select>
                    </label>
                </div>

                @if($user)
                    <div class="rounded-3xl glass">
                        <div class="flex p-2 relative">
                            <img
                                    src="{{ user()->getUser($user)->getAvatarURL() }}"
                                    alt="Avatar"
                                    class="rounded-full w-8 h-8 m-1">
                            <p class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]">{{ $user->username }}</p>
                        </div>

                    </div>
                @endif

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-alert icon="o-exclamation-triangle"
                                 class="alert-error">{{ __('auth.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-alert>
                    </div>
                @endif

                @if(session('error'))
                    <x-alert icon="o-exclamation-triangle"
                             class="alert-error">{{ session('error') }}
                    </x-alert>
                @endif

                @if(setting('auth_enable_local_login'))
                    @if($twoFactorEnabled)
                        <x-form class="space-y-4 md:space-y-6" wire:submit="checkTwoFactorCode">
                            @csrf

                            <x-input label="{{ __('auth.login.two_factor_or_recovery_code') }}"
                                     class="input-bordered w-full"
                                     required="" wire:model="twoFactorCode"/>

                            <div>
                                <x-button type="submit"
                                          class="btn btn-primary w-full" spinner="checkTwoFactorCode">
                                    {{ __('auth.login.buttons.login') }}
                                </x-button>

                                <a href="{{ route('auth.login') }}"
                                   class="btn btn-neutral w-full mt-2" wire:navigate>
                                    {{ __('messages.buttons.back') }}
                                </a>
                            </div>
                        </x-form>
                    @else
                        <x-form class="space-y-4 md:space-y-6" wire:submit="attemptLogin">
                            @csrf
                            <x-input label="{{ __('messages.username') }}"
                                     class="input-bordered w-full"
                                     wire:model="username"
                                     wire:blur="checkIfUserExits($event.target.value)" required/>


                            <x-input label="{{ __('messages.password') }}"
                                     class="input-bordered w-full"
                                     type="password"
                                     wire:model="password" required/>

                            <x-checkbox label="{{ __('auth.login.remember_me') }}"
                                        class="checkbox checkbox-md"
                                        wire:model="rememberMe"/>

                            @if(setting('auth_enable_captcha'))
                                <div class="gap-3 md:flex space-y-3">
                                    <img src="{{ captcha_src() }}" alt="Captcha">

                                    <div class="form-control md:w-1/2 w-full">
                                        <x-input label="{{ __('messages.captcha') }}"
                                                 required
                                                 class="input-bordered w-full" wire:model="captcha"/>
                                    </div>
                                </div>
                            @endif

                            <x-button type="submit"
                                      class="btn btn-primary w-full" spinner="attemptLogin">
                                {{ __('auth.login.buttons.login') }}
                            </x-button>
                        </x-form>
                    @endif
                @endif
                <div class="space-y-4 mt-4">
                    @if(setting('auth_enable_local_login') && !$twoFactorEnabled)
                        @if(setting('auth_enable_forgot_password') ||
                            setting('auth_enable_register') ||
                            setting('auth_enable_oauth'))
                            <div class="divider">{{ strtoupper(__('messages.or')) }}</div>
                        @endif

                        <div class="grid lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] grid-cols-1 gap-4">

                            @if(setting('auth_enable_forgot_password'))
                                <a href="{{ route('auth.forgot-password', '') }}"
                                   class="btn btn-neutral"
                                   wire:navigate>{{ __('auth.login.buttons.forgot_password') }}</a>
                            @endif

                            @if(setting('auth_enable_register'))
                                <a href="{{ route('auth.register') }}"
                                   class="btn btn-neutral"
                                   wire:navigate>{{ __('auth.login.buttons.register') }}</a>
                            @endif
                        </div>
                    @endif

                    @if(setting('auth_enable_oauth') && !$twoFactorEnabled)
                        <div
                                class="grid lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] md:grid-cols-2 grid-cols-1 gap-4">

                            @if(setting('oauth_enable_google'))
                                <a href="{{ route('auth.redirect', 'google') }}"
                                   class="btn hover:bg-red-500 bg-red-600 text-white w-full">{!! __('auth.login.login_with.google') !!}</a>
                            @endif

                            @if(setting('oauth_enable_github'))
                                <a href="{{ route('auth.redirect', 'github') }}"
                                   class="btn hover:bg-gray-950 bg-black text-white w-full">{!! __('auth.login.login_with.github') !!}</a>
                            @endif

                            @if(setting('oauth_enable_discord'))
                                <a href="{{ route('auth.redirect', 'discord') }}"
                                   class="btn hover:bg-indigo-500 bg-indigo-600 text-white w-full">{!! __('auth.login.login_with.discord') !!}</a>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($unsplash['error'] == null)
        <div class="pl-6 pb-4 text-white">
            <span class="text-sm" id="credits" wire:ignore><a id="photo"
                                                              href="{{ $unsplash['photo'] }}/{{ setting('unsplash_utm') }}">{{ __('messages.photo') }}</a>, <a
                        id="author"
                        href="{{ $unsplash['authorURL'] }}/{{ setting('unsplash_utm') }}">{{ $unsplash['author'] }}</a>, <a
                        href="https://unsplash.com/{{ setting('unsplash_utm') }}">Unsplash</a></span>
        </div>
    @endif
</div>
