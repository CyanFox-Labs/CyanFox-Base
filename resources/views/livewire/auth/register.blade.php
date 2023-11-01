<div class="flex flex-col justify-between min-h-screen relative">
    <div wire:ignore id="bg_image" class="absolute inset-0 z-[-1]">
    </div>
    <script src="{{ asset("js/sites/background.js") }}"></script>

    <div class="flex flex-col items-center justify-center px-6 mx-auto py-6">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("img/Logo.png") }}" alt="logo">
            <span
                class="text-4xl font-bold brand-text lg:block hidden" id="logo_text"
                wire:ignore>{{ env('APP_NAME') }}</span>
        </p>
        <div class="bg-neutral rounded-box sm:w-full w-auto">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-custom.alert type="error" icon="bx bxs-error"
                                        class="alert-error">{{ __('pages/register.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-custom.alert>
                    </div>
                @endif
                <form class="space-y-4 md:space-y-6" onsubmit="event.preventDefault()">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <div class="form-control w-full">
                            <label class="label" for="first_name">
                                <span class="label-text">{{ __('pages/register.first_name') }}</span>
                            </label>
                            <input id="first_name" type="text"
                                   class="input input-bordered w-full" wire:model="first_name"/>
                        </div>
                        <div class="form-control w-full">
                            <label class="label" for="last_name">
                                <span class="label-text">{{ __('pages/register.last_name') }}</span>
                            </label>
                            <input id="last_name" type="text"
                                   class="input input-bordered w-full" wire:model="last_name"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label" for="username">
                                <span class="label-text">{{ __('pages/register.username') }}</span>
                            </label>
                            <input id="username" type="text"
                                   class="input input-bordered w-full" wire:model="username"/>
                        </div>
                        <div class="form-control w-full">
                            <label class="label" for="email">
                                <span class="label-text">{{ __('pages/register.email') }}</span>
                            </label>
                            <input id="email" type="email"
                                   class="input input-bordered w-full" wire:model="email"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label" for="password">
                                <span class="label-text">{{ __('pages/register.password') }}</span>
                            </label>
                            <input id="password" type="password"
                                   class="input input-bordered w-full" wire:model="password"/>
                        </div>
                        <div class="form-control w-full">
                            <label class="label" for="password_confirm">
                                <span class="label-text">{{ __('pages/register.password_confirm') }}</span>
                            </label>
                            <input id="password_confirm" type="password"
                                   class="input input-bordered w-full" wire:model="password_confirm"/>
                        </div>
                    </div>

                    @if(env('ENABLE_HCAPTCHA'))
                        <x-custom.hcaptcha fieldName="hcaptcha"></x-custom.hcaptcha>
                    @endif

                    <div class="flex justify-between items-center">
                        <button type="submit"
                                class="flex-1 mr-2 btn btn-primary"
                                wire:click="register" wire:ignore>
                            {{ __('pages/register.register') }}
                        </button>

                        <details class="dropdown ">
                            <summary class="m-1 btn">{{ __('messages.language') }}</summary>
                            <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-32">
                                <li><a wire:click="setLanguage('de')">{{ __('messages.languageType.de') }}</a></li>
                                <li><a wire:click="setLanguage('en')">{{ __('messages.languageType.en') }}</a></li>
                            </ul>
                        </details>
                    </div>

                    <div class="grid gap-4 mt-4">
                        <a href="{{ route('login') }}"
                           class="btn btn-ghost">
                            {{ __('pages/register.login') }}
                        </a>
                    </div>
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
