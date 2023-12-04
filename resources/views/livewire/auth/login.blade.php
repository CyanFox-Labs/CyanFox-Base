<div class="flex flex-col justify-between min-h-screen relative">
    <div wire:ignore id="bg_image" class="absolute inset-0 z-[-1]">
    </div>
    <script src="{{ asset("js/sites/background.js") }}"></script>

    <div class="flex flex-col justify-center items-center">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("img/Logo.png") }}" alt="logo">
            <span
                class="text-4xl font-bold brand-text lg:block hidden" id="logo_text"
                wire:ignore>{{ env('APP_NAME') }}</span>
        </p>
        <div class="bg-neutral rounded-box sm:w-96 w-auto">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">

                @if($user)
                    <div class="glass rounded-3xl">
                        <div class="flex p-2 relative">
                            <img
                                src="https://source.boringavatars.com/beam/120/{{ $user->username }}"
                                alt="Avatar"
                                class="rounded-full w-8 h-8 m-1">
                            <p class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]">{{ $user->username }}</p>
                        </div>

                    </div>
                @endif

                @if(session('error') !== null)
                    <x-alert icon="o-exclamation-triangle"
                             class="alert-error">{{ session('error') }}</x-alert>
                @endif

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-alert icon="o-exclamation-triangle"
                                 class="alert-error">{{ __('pages/auth/login.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-alert>
                    </div>
                @endif

                @if($two_factor_enabled)
                    <x-form class="space-y-2 md:space-y-6" wire:submit="checkTwoFactorCode">
                        @csrf
                        <x-input label="{{ __('messages.two_factor_code') }}"
                                 class="input input-bordered w-full"
                                 required="" wire:model="two_factor_code"/>

                        <div class="flex items-center space-x-2 w-full">
                            <a href="{{ route('login') }}"
                               class="btn btn-neutral w-1/2">
                                {{ __('messages.back') }}
                            </a>
                            <x-button type="submit"
                                      class="btn btn-primary w-1/2" spinner="checkTwoFactorCode">
                                {{ __('pages/auth/login.buttons.login') }}
                            </x-button>
                        </div>
                    </x-form>
                @else
                    <x-form class="space-y-4 md:space-y-6" wire:submit="attemptLogin">
                        @csrf
                        <div>
                            <div class="form-control w-full">
                                <x-input label="{{ __('messages.username') }}"
                                         wire:model="username"
                                         wire:blur="checkIfUserExits($event.target.value)" required/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <x-input type="password" label="{{ __('messages.password') }}" wire:model="password"
                                         required/>
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <x-checkbox label="{{ __('pages/auth/login.remember_me') }}"
                                            wire:model="remember_me" class="mt-3 font-semibold" right bottom/>
                            </label>
                        </div>
                        <div class="flex justify-between items-center">
                            <x-button type="submit"
                                      class="flex-1 mr-2 btn btn-primary" spinner="attemptLogin">
                                {{ __('pages/auth/login.buttons.login') }}
                            </x-button>

                            <details class="dropdown">
                                <summary class="m-1 btn">{{ __('messages.language') }}</summary>
                                <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-32">
                                    <li><a wire:click="setLanguage('de')">{{ __('messages.language_types.de') }}</a>
                                    </li>
                                    <li><a wire:click="setLanguage('en')">{{ __('messages.language_types.en') }}</a>
                                    </li>
                                </ul>
                            </details>
                        </div>
                    </x-form>
                    <div class="grid gap-4 mt-4">
                        @if(env('GITHUB_LOGIN_ENABLED'))
                            <a href="{{ route('auth.redirect', 'github') }}"
                               class="btn hover:bg-black bg-black text-white">
                                {!! __('pages/auth/login.buttons.login_github') !!}
                            </a>
                        @endif

                        @if(env('GITLAB_LOGIN_ENABLED'))
                            <a href="{{ route('auth.redirect', 'gitlab') }}"
                               class="btn hover:bg-orange-600 bg-orange-500 text-white">
                                {!! __('pages/auth/login.buttons.login_gitlab') !!}
                            </a>
                        @endif

                        @if(env('GOOGLE_LOGIN_ENABLED'))
                            <a href="{{ route('auth.redirect', 'google') }}"
                               class="btn hover:bg-red-600 bg-red-500 text-white">
                                {!! __('pages/auth/login.buttons.login_google') !!}
                            </a>
                        @endif
                    </div>
                    <div
                        class="grid @if(env('ENABLE_REGISTRATION') && env('ENABLE_FORGOT_PASSWORD')) md:grid-cols-2 @endif gap-4 mt-4">
                        @if(env('ENABLE_FORGOT_PASSWORD'))
                            <a href="{{ route('forgot-password', [""]) }}"
                               class="btn btn-ghost">
                                {{ __('pages/auth/login.buttons.forgot_password') }}
                            </a>
                        @endif
                        @if(env('ENABLE_REGISTRATION'))
                            <a href="{{ route('register') }}"
                               class="btn btn-ghost">
                                {{ __('pages/auth/messages.buttons.register') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="pl-6 pb-4" id="unsplashCredits" wire:ignore>
        <span class="text-sm" id="credits" wire:ignore><a id="photo" data-trans="{{ __('messages.photo') }}"></a>, <a
                id="author"></a>, <a
                href="https://unaplash.com/utm_source=CyanFox&utm_medium=referral">Unsplash</a></span>
    </div>
</div>
