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

                <form class="space-y-4 md:space-y-6" onsubmit="event.preventDefault()">
                    @csrf

                    <div class="flex justify-center">

                        <div class="flex flex-col items-center mr-6">
                            <img src="data:image/svg+xml;base64,{{ $twoFactorImage }}" alt="Two Factor Image"
                                 class="border-4 border-white mb-2">
                            <p>{{ $twoFactorSecret }}</p>
                        </div>

                        <div class="space-y-4">
                            <div class="form-control w-full max-w-xs">
                                <label class="label" for="two_factor_key">
                                    <span class="label-text">{{ __('pages/account/activate-two-factor.two_factor_key') }}</span>
                                </label>
                                <input type="number" id="two_factor_key" class="input input-bordered w-full max-w-xs"
                                       wire:model="two_factor_key"/>
                            </div>

                            <div class="form-control w-full max-w-xs">
                                <label class="label" for="password">
                                    <span class="label-text">{{ __('messages.password') }}</span>
                                </label>
                                <input type="password" id="password" class="input input-bordered w-full max-w-xs"
                                       wire:model="password"/>
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit"
                                class="flex-1 mr-2 btn btn-primary"
                                wire:click="activateTwoFactor" wire:ignore>
                            {{ __('pages/account/activate-two-factor.activate_two_factor') }}
                        </button>
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
