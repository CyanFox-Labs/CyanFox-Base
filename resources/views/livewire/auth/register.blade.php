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
                <div class="flex justify-end">
                    <label>
                        <select class="select select-bordered" wire:blur="changeLanguage($event.target.value)"
                                wire:model="language">
                            <option value="en">{{ __('messages.languages.en') }}</option>
                            <option value="de">{{ __('messages.languages.de') }}</option>
                        </select>
                    </label>
                </div>

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-alert icon="o-exclamation-triangle"
                                 class="alert-error">{{ __('auth.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-alert>
                    </div>
                @endif

                <x-form wire:submit="register">
                    @csrf
                    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">
                        <x-input label="{{ __('messages.first_name') }}"
                                 class="input-bordered w-full"
                                 wire:model="firstName" required/>

                        <x-input label="{{ __('messages.last_name') }}"
                                 class="input-bordered w-full"
                                 wire:model="lastName" required/>


                        <x-input label="{{ __('messages.username') }}"
                                 class="input-bordered w-full"
                                 wire:model="username" required/>

                        <x-input label="{{ __('messages.email') }}"
                                 type="email"
                                 class="input-bordered w-full"
                                 wire:model="email" required/>


                        <x-input label="{{ __('messages.password') }}"
                                 type="password"
                                 class="input-bordered w-full"
                                 wire:model="password" required/>

                        <x-input label="{{ __('messages.confirm_password') }}"
                                 type="password"
                                 class="input-bordered w-full"
                                 wire:model="passwordConfirmation" required/>
                    </div>

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

                    <div class="divider"></div>

                    <x-button type="submit"
                              class="btn btn-primary w-full" spinner="register">
                        {{ __('auth.register.buttons.register') }}
                    </x-button>

                </x-form>

                <a href="{{ route('auth.login') }}" class="btn btn-neutral mt-3 w-full" wire:navigate>{{ __('auth.buttons.back_to_login') }}</a>
            </div>
        </div>
    </div>
    @if($unsplash['error'] == null)
        <div class="pl-6 pb-4 text-white">
            <span class="text-sm" id="credits" wire:ignore><a id="photo"
                                                              href="{{ $unsplash['photo'] }}">{{ __('messages.photo') }}</a>, <a
                    id="author"
                    href="{{ $unsplash['authorURL'] }}">{{ $unsplash['author'] }}</a>, <a
                    href="https://unsplash.com/{{ setting('unsplash_utm') }}">Unsplash</a></span>
        </div>
    @endif
</div>
