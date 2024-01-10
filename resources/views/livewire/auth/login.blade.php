<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col justify-center items-center">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("img/Logo.png") }}" alt="Logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden">{{ config('app.name') }}</span>
        </p>
        <div class="card bg-base-200 sm:w-96 w-auto">
            <div class="card-body">

                @if($user)
                    <div class="glass rounded-3xl">
                        <div class="flex p-2 relative">
                            <img
                                src="{{ $user->getAvatarURL() }}"
                                alt="Avatar"
                                class="rounded-full w-8 h-8 m-1">
                            <p class="absolute top-1/2 left-1/2 translate-x-[-50%] translate-y-[-50%]">{{ $user->username }}</p>
                        </div>

                    </div>
                @endif

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-alert icon="o-exclamation-triangle"
                                 class="alert-error">{{ __('pages/auth/login.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-alert>
                    </div>
                @endif

                @if(!get_setting('auth', 'disable_local_login'))
                    @if($twoFactorEnabled)
                        <x-form class="space-y-4 md:space-y-6" wire:submit="checkTwoFactorCode">
                            @csrf

                            <x-input label="{{ __('messages.two_factor_code') }}"
                                     class="input input-bordered w-full"
                                     required="" wire:model="twoFactorCode"/>

                            <x-button type="submit"
                                      class="btn btn-primary w-full" spinner="checkTwoFactorCode">
                                {{ __('pages/auth/login.buttons.login') }}
                            </x-button>
                            <a href="{{ route('auth.login') }}"
                               class="btn btn-neutral">
                                {{ __('messages.back') }}
                            </a>
                        </x-form>
                    @else
                        <x-form class="space-y-4 md:space-y-6" wire:submit="attemptLogin">
                            @csrf
                            <x-input label="{{ __('pages/auth/messages.username') }}"
                                     class="input input-bordered w-full"
                                     wire:model="username"
                                     wire:blur="checkIfUserExits($event.target.value)" required/>


                            <x-input label="{{ __('pages/auth/messages.password') }}"
                                     class="input input-bordered w-full"
                                     wire:model="password" required/>

                            <x-checkbox label="{{ __('pages/auth/login.remember_me') }}"
                                        class="checkbox checkbox-md"
                                        wire:model="rememberMe"/>

                            <x-button type="submit"
                                      class="btn btn-primary w-full" spinner="attemptLogin">
                                {{ __('pages/auth/login.buttons.login') }}
                            </x-button>
                        </x-form>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @if($unsplash['error'] == null)
        <div class="pl-6 pb-4 text-white">
            <span class="text-sm" id="credits" wire:ignore><a id="photo"
                                                              href="{{ $unsplash['photo'] }}">{{ __('pages/auth/messages.photo') }}</a>, <a
                    id="author" href="{{ $unsplash['authorURL'] }}">{{ $unsplash['author'] }}</a>, <a
                    href="https://unsplash.com/{{ get_setting('unsplash', 'utm') }}">Unsplash</a></span>
        </div>
    @endif
</div>
