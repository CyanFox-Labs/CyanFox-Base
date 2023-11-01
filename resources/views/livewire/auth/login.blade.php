<div class="flex flex-col justify-between min-h-screen relative">
    <div wire:ignore id="bg_image" class="absolute inset-0 z-[-1]">
    </div>
    <link rel="stylesheet" href="{{ asset("css/sites/login.css") }}">
    <script src="{{ asset("js/sites/background.js") }}"></script>

    <div class="flex flex-col items-center justify-center px-6 mx-auto py-6">
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
                        <div class="flex p-2 profile">
                            <img
                                src="https://source.boringavatars.com/beam/120/{{ $user->username }}"
                                alt="Avatar"
                                class="rounded-full w-8 h-8 m-1">
                            <p>{{ $user->username }}</p>
                        </div>

                    </div>
                @elseif($username !== null)
                    @if(!session('error'))
                        <x-custom.alert icon="bx bxs-error"
                                        class="alert-error">{{ __('pages/login.not_found') }}</x-custom.alert>
                    @endif
                @endif

                @if(session('error') !== null)
                    <x-custom.alert type="error" icon="bx bxs-error"
                                    class="alert-error">{{ session('error') }}</x-custom.alert>
                @endif

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-custom.alert type="error" icon="bx bxs-error"
                                        class="alert-error">{{ __('pages/login.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-custom.alert>
                    </div>
                @endif
                <form class="space-y-4 md:space-y-6" onsubmit="event.preventDefault()">
                    @csrf
                    @if($two_factor_enabled)
                        <div>
                            <label for="two_factor_code"
                                   class="block mb-2 text-sm font-medium"
                                   wire:ignore>{{ __('pages/login.two_factor') }}</label>
                            <input type="text" name="two_factor_code" id="two_factor_code"
                                   class="input input-bordered w-full"
                                   required="" wire:model="two_factor_code">
                        </div>

                        <div class="flex items-center space-x-2 w-full">
                            <a href="/login"
                               class="btn btn-neutral w-1/2">
                                {{ __('messages.back') }}
                            </a>
                            <button type="submit"
                                    class="btn btn-primary w-1/2"
                                    wire:click="checkTwoFactorCode">
                                {{ __('pages/login.login') }}
                            </button>
                        </div>

                    @else
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="username">
                                    <span class="label-text" wire:ignore>{{ __('pages/login.username') }}</span>
                                </label>
                                <input type="text" id="username"
                                       class="input input-bordered w-full" wire:model="username"
                                       wire:blur="checkIfUserExits($event.target.value)"
                                />
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="password">
                                    <span class="label-text" wire:ignore>{{ __('messages.password') }}</span>
                                </label>
                                <input type="password" id="password"
                                       class="input input-bordered w-full" wire:model="password"/>
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <span class="label-text" wire:ignore>{{ __('pages/login.remember_me') }}</span>
                                <input type="checkbox" checked="checked" class="checkbox"
                                       wire:model="remember_me"/>
                            </label>
                        </div>
                        <div class="flex justify-between items-center">
                            <button type="submit"
                                    class="flex-1 mr-2 btn btn-primary"
                                    wire:click="attemptLogin" wire:ignore>
                                {{ __('pages/login.login') }}
                            </button>

                            <details class="dropdown">
                                <summary class="m-1 btn">{{ __('messages.language') }}</summary>
                                <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-32">
                                    <li><a wire:click="setLanguage('de')">{{ __('messages.languageType.de') }}</a></li>
                                    <li><a wire:click="setLanguage('en')">{{ __('messages.languageType.en') }}</a></li>
                                </ul>
                            </details>
                        </div>
                        <div
                            class="grid @if(env('ENABLE_REGISTRATION') && env('ENABLE_FORGOT_PASSWORD')) md:grid-cols-2 @endif gap-4 mt-4">
                            @if(env('ENABLE_FORGOT_PASSWORD'))
                                <a href="{{ route('forgot-password', [""]) }}"
                                   class="btn btn-ghost">
                                    {{ __('pages/login.forgot_password') }}
                                </a>
                            @endif
                            @if(env('ENABLE_REGISTRATION'))
                                <a href="{{ route('register') }}"
                                   class="btn btn-ghost">
                                    {{ __('pages/login.register') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="pl-6 pb-4" id="unsplashCredits" wire:ignore>
        <span class="text-sm" id="credits" wire:ignore><a id="photo">{{ __('messages.photo') }}</a>, <a
                id="author"></a>, <a
                href="https://unaplash.com/utm_source=CyanFox&utm_medium=referral">Unsplash</a></span>
    </div>
</div>
