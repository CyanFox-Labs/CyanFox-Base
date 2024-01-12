<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col justify-center items-center">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("img/Logo.png") }}" alt="Logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden">{{ config('app.name') }}</span>
        </p>
        <div class="card bg-base-200 sm:w-1/3 w-auto">
            <div class="card-body">
                <div class="flex justify-end">
                    <label>
                        <select class="select select-bordered" wire:blur="changeLanguage($event.target.value)"
                                wire:model="language">
                            <option disabled selected>Language</option>
                            <option value="en">{{ __('messages.languages.english') }}</option>
                            <option value="de">{{ __('messages.languages.german') }}</option>
                        </select>
                    </label>
                </div>

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-alert icon="o-exclamation-triangle"
                                 class="alert-error">{{ __('pages/auth/login.rate_limit', ['seconds' => $rateLimitTime]) }}
                        </x-alert>
                    </div>
                @endif

                <x-form class="space-y-4 md:space-y-6" wire:submit="register">
                    @csrf
                    <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">
                        <x-input label="{{ __('pages/auth/register.first_name') }}"
                                 class="input input-bordered w-full"
                                 wire:model="firstName" required/>

                        <x-input label="{{ __('pages/auth/register.last_name') }}"
                                 class="input input-bordered w-full"
                                 wire:model="lastName" required/>


                        <x-input label="{{ __('pages/auth/messages.username') }}"
                                 class="input input-bordered w-full"
                                 wire:model="username" required/>

                        <x-input label="{{ __('pages/auth/messages.email') }}"
                                 type="email"
                                 class="input input-bordered w-full"
                                 wire:model="email" required/>


                        <x-input label="{{ __('pages/auth/messages.password') }}"
                                 type="password"
                                 class="input input-bordered w-full"
                                 wire:model="password" required/>

                        <x-input label="{{ __('pages/auth/register.confirm_password') }}"
                                 type="password"
                                 class="input input-bordered w-full"
                                 wire:model="passwordConfirmation" required/>
                    </div>

                    <x-button type="submit"
                              class="btn btn-primary w-full" spinner="register">
                        {{ __('pages/auth/register.buttons.register') }}
                    </x-button>

                </x-form>

                <a href="{{ route('auth.login') }}" class="btn btn-neutral mt-3 w-full">{{ __('pages/auth/messages.buttons.back_to_login') }}</a>
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
