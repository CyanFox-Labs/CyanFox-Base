<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col md:justify-center md:items-center">
        <p class="flex items-center justify-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32" src="{{ asset("img/Logo.svg") }}" alt="Logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden">{{ setting('app_name') }}</span>
        </p>
        <div class="card bg-base-200 lg:w-1/3 sm:min-w-96 sm:w-1/8 w-auto">
            <div class="card-body">
                <x-form method="dialog" wire:submit="activateTwoFactor">
                    @csrf
                    <div class="md:flex justify-center mb-3">

                        <div class="flex flex-col items-center mr-4">
                            <img src="data:image/svg+xml;base64,{{ user()->getUser(auth()->user())->getTwoFactorManager()->getTwoFactorImage() }}" alt="Two Factor Image"
                                 class="border-4 border-white mb-2">
                            <p>{{ decrypt(auth()->user()->two_factor_secret) }}</p>
                        </div>

                        <div class="space-y-4 md:mt-2 mt-6">
                            <x-input label="{{ __('messages.password') }}"
                                     type="password" class="input-bordered"
                                     wire:model="password" required/>

                            <x-input label="{{ __('messages.two_factor_code') }}"
                                     class="input-bordered"
                                     wire:model="twoFactorCode" required/>
                        </div>

                    </div>

                    <div class="divider"></div>

                    <div class="mt-2 flex justify-between gap-3">
                        <button class="btn btn-neutral flex-grow" type="button"
                                wire:click="$dispatch('closeModal')">{{ __('messages.buttons.cancel') }}</button>

                        <x-button class="btn btn-success flex-grow"
                                  type="submit" spinner="activateTwoFactor">
                            {{ __('account/force_activate.force_activate_two_factor.buttons.activate_two_factor') }}
                        </x-button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
    @if($unsplash['error'] == null)
        <div class="pl-6 pb-4 text-white">
            <span class="text-sm" id="credits" wire:ignore><a id="photo"
                                                              href="{{ $unsplash['photo'] }}/{{ setting('unsplash_utm') }}">{{ __('messages.photo') }}</a>, <a
                    id="author" href="{{ $unsplash['authorURL'] }}/{{ setting('unsplash_utm') }}">{{ $unsplash['author'] }}</a>, <a
                    href="https://unsplash.com/{{ setting('unsplash_utm') }}">Unsplash</a></span>
        </div>
    @endif
</div>
