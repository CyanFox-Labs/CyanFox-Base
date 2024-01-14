<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col justify-center items-center">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("img/Logo.png") }}" alt="Logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden">{{ setting('app_name') }}</span>
        </p>
        <div class="card bg-base-200 sm:min-w-96 sm:w-1/8 w-auto">
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

                @if($user)
                    <div class="glass rounded-3xl mt-2">
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

                @if($resetToken == null)
                    <x-form class="space-y-4 md:space-y-6" wire:submit="sendResetLink">
                        @csrf
                        <x-input label="{{ __('pages/auth/messages.email') }}"
                                 class="input input-bordered w-full"
                                 wire:model="email"
                                 wire:blur="checkIfUserExits($event.target.value)" required/>

                        <x-button type="submit"
                                  class="btn btn-primary w-full" spinner="sendResetLink">
                            {{ __('pages/auth/forgot_password.buttons.send_reset_link') }}
                        </x-button>
                    </x-form>
                @else
                    <x-form class="space-y-4 md:space-y-6" wire:submit="resetPassword">
                        @csrf
                        <x-input label="{{ __('pages/auth/messages.password') }}"
                                 type="password"
                                 class="input input-bordered w-full" wire:model="password"
                                 required />

                        <x-input label="{{ __('pages/auth/forgot_password.confirm_password') }}"
                                 type="password"
                                 class="input input-bordered w-full" wire:model="passwordConfirmation"
                                 required />

                        <x-button type="submit"
                                  class="btn btn-primary w-full" spinner="resetPassword">
                            {{ __('pages/auth/forgot_password.buttons.reset_password') }}
                        </x-button>
                    </x-form>
                @endif

                <a href="{{ route('auth.login') }}"
                   class="btn btn-neutral mt-3 w-full">{{ __('pages/auth/messages.buttons.back_to_login') }}</a>
            </div>
        </div>
    </div>
    @if($unsplash['error'] == null)
        <div class="pl-6 pb-4 text-white">
            <span class="text-sm" id="credits" wire:ignore><a id="photo"
                                                              href="{{ $unsplash['photo'] }}">{{ __('pages/auth/messages.photo') }}</a>, <a
                    id="author" href="{{ $unsplash['authorURL'] }}">{{ $unsplash['author'] }}</a>, <a
                    href="https://unsplash.com/{{ setting('unsplash_utm', '?utm_source=your_app_name&utm_medium=referral') }}">Unsplash</a></span>
        </div>
    @endif
</div>
