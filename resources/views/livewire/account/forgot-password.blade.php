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


                @if($resetToken == null)
                    <x-form class="space-y-2 md:space-y-6" wire:submit="sendLink">
                        @csrf
                        <div class="form-control w-full">
                            <x-input label="{{ __('messages.email') }}"
                                     type="email"
                                     class="input input-bordered w-full" wire:model="email"/>
                        </div>

                        <div class="flex justify-between items-center">
                            <x-button type="submit"
                                      class="flex-1 mr-2 btn btn-primary" spinner="sendLink">
                                {{ __('pages/account/forgot-password.buttons.send_link') }}
                            </x-button>

                            <details class="dropdown">
                                <summary class="m-1 btn">{{ __('messages.language') }}</summary>
                                <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-32">
                                    <li><a wire:click="setLanguage('de')">{{ __('messages.language_types.de') }}</a></li>
                                    <li><a wire:click="setLanguage('en')">{{ __('messages.language_types.en') }}</a></li>
                                </ul>
                            </details>
                        </div>
                    </x-form>
                @else
                    <x-form class="space-y-2 md:space-y-6" wire:submit="resetPassword">
                        <div class="form-control w-full">
                            <x-input label="{{ __('messages.password') }}"
                                     type="password"
                                     class="input input-bordered w-full" wire:model="password"/>
                        </div>

                        <div class="form-control w-full">
                            <x-input label="{{ __('messages.confirm_password') }}"
                                     type="password"
                                     class="input input-bordered w-full" wire:model="password_confirm"/>
                        </div>

                        <div class="flex justify-between items-center">
                            <x-button type="submit"
                                      class="flex-1 mr-2 btn btn-primary" spinner="resetPassword">
                                {{ __('pages/account/forgot-password.buttons.reset_password') }}
                            </x-button>

                            <details class="dropdown">
                                <summary class="m-1 btn">{{ __('messages.language') }}</summary>
                                <ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-32">
                                    <li><a wire:click="setLanguage('de')">{{ __('messages.language_types.de') }}</a></li>
                                    <li><a wire:click="setLanguage('en')">{{ __('messages.language_types.en') }}</a></li>
                                </ul>
                            </details>
                        </div>
                    </x-form>
                @endif
                <div
                    class="grid gap-4 mt-4">
                    <a href="{{ route('login') }}"
                       class="btn btn-ghost">
                        {{ __('pages/auth/messages.buttons.back_to_login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="pl-6 pb-4" id="unsplashCredits" wire:ignore>
        <span class="text-sm" id="credits" wire:ignore><a id="photo" data-trans="{{ __('messages.photo') }}"></a>, <a
                id="author"></a>, <a
                href="https://unaplash.com/utm_source=CyanFox&utm_medium=referral">Unsplash</a></span>
    </div>
</div>
