<div class="flex flex-col justify-between min-h-screen relative">
    <div wire:ignore id="bg_image" class="absolute inset-0 z-[-1]">
    </div>
    <script src="{{ asset("js/sites/background.js") }}"></script>

    <div class="flex flex-col items-center justify-center px-6 mx-auto py-6">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("img/Logo.png") }}" alt="logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden" id="logo_text"
                wire:ignore>{{ env('APP_NAME') }}</span>
        </p>
        <div class="bg-neutral rounded-box sm:w-full w-auto">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">

                <x-form class="space-y-4 md:space-y-6" wire:submit="activateTwoFactor">
                    @csrf

                    <div class="flex justify-center">

                        <div class="flex flex-col items-center mr-6">
                            <img src="data:image/svg+xml;base64,{{ $twoFactorImage }}" alt="Two Factor Image"
                                 class="border-4 border-white mb-2">
                            <p>{{ $twoFactorSecret }}</p>
                        </div>

                        <div class="space-y-4">
                            <div class="form-control w-full max-w-xs">
                                <x-input label="{{ __('messages.two_factor_code') }}"
                                         type="number" class="input input-bordered w-full max-w-xs"
                                         wire:model="two_factor_code"/>
                            </div>

                            <div class="form-control w-full max-w-xs">
                                <x-input label="{{ __('messages.password') }}" type="password"
                                       class="input input-bordered w-full max-w-xs"
                                       wire:model="password"/>
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-between items-center">
                        <x-button type="submit"
                                class="flex-1 mr-2 btn btn-primary" spinner="activateTwoFactor">
                            {{ __('pages/account/messages.buttons.activate_two_factor') }}
                        </x-button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
    <div class="pl-6 pb-4" id="unsplashCredits" wire:ignore>
        <span class="text-sm" id="credits" wire:ignore><a id="photo" data-trans="{{ __('messages.photo') }}" data-utm="?{{ env('UNSPLASH_UTM') }}"></a>, <a
                id="author"></a>, <a
                href="https://unsplash.com/?{{ env('UNSPLASH_UTM') }}">Unsplash</a></span>
    </div>
</div>
