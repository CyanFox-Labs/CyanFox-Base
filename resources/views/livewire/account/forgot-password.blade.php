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
        <div class="bg-neutral rounded-box sm:w-96 w-auto">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">

                <form class="space-y-4 md:space-y-6" onsubmit="event.preventDefault()">
                    @csrf
                    @if($resetToken == null)
                        <div class="form-control w-full">
                            <label class="label" for="email">
                                <span class="label-text"
                                      wire:ignore>{{ __('pages/account/forgot-password.email') }}</span>
                            </label>
                            <input type="email" id="email"
                                   class="input input-bordered w-full" wire:model="email"/>
                        </div>
                    @else
                        <div class="form-control w-full">
                            <label class="label" for="password">
                                <span class="label-text"
                                      wire:ignore>{{ __('pages/account/forgot-password.password') }}</span>
                            </label>
                            <input type="password" id="password"
                                   class="input input-bordered w-full" wire:model="password"/>
                        </div>

                        <div class="form-control w-full">
                            <label class="label" for="password_confirm">
                                <span class="label-text"
                                      wire:ignore>{{ __('pages/account/forgot-password.password_confirm') }}</span>
                            </label>
                            <input type="password" id="password_confirm"
                                   class="input input-bordered w-full" wire:model="password_confirm"/>
                        </div>
                    @endif

                    <div class="flex justify-between items-center">
                        @if($resetToken == null)
                            <button type="submit"
                                    class="flex-1 mr-2 btn btn-primary"
                                    wire:click="sendLink" wire:ignore>
                                {{ __('pages/account/forgot-password.send_link') }}
                            </button>
                        @else
                            <button type="submit"
                                    class="flex-1 mr-2 btn btn-primary"
                                    wire:click="resetPassword" wire:ignore>
                                {{ __('pages/account/forgot-password.reset') }}
                            </button>
                        @endif

                        <details class="dropdown">
                            <summary class="m-1 btn">{{ __('messages.language') }}</summary>
                            <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-32">
                                <li><a wire:click="setLanguage('de')">{{ __('messages.languageType.de') }}</a></li>
                                <li><a wire:click="setLanguage('en')">{{ __('messages.languageType.en') }}</a></li>
                            </ul>
                        </details>
                    </div>
                    <div
                        class="grid gap-4 mt-4">
                        <a href="{{ route('login') }}"
                           class="btn btn-ghost">
                            {{ __('pages/account/forgot-password.login') }}
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
