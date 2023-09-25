<section class="h-screen flex flex-col justify-between">
    <link rel="stylesheet" href="{{ asset("/css/sites/login.css") }}">
    <script src="{{ asset("/js/sites/login.js") }}"></script>

    <div class="flex flex-col items-center justify-center px-6 mx-auto py-6">
        <p class="flex items-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32 mr-2" src="{{ asset("/img/Logo.png") }}" alt="logo">
            <span
                class="text-4xl font-bold brand-text lg:block hidden">{{ env('APP_NAME') }}</span>
        </p>
        <div
            class="card glass sm:w-96 w-auto">
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
                        <x-alert type="error" icon="bx bxs-error"
                                 class="alert-error">{{ __('User not found') }}</x-alert>
                    @endif
                @endif

                @if(session('error') !== null)
                    <x-alert type="error" icon="bx bxs-error" class="alert-error">{{ session('error') }}</x-alert>
                @endif

                @if ($rateLimitTime > 1)
                    <div wire:poll.1s="setRateLimit">
                        <x-alert type="error" icon="bx bxs-error"
                                 class="alert-error">{{ __('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $rateLimitTime]) }}
                        </x-alert>
                    </div>
                @endif
                <form class="space-y-4 md:space-y-6" onsubmit="event.preventDefault()">
                    @csrf
                    @if($two_factor_enabled)
                        <div>
                            <label for="two_factor_code"
                                   class="block mb-2 text-sm font-medium">{{ __('2FA Code / Recovery Code') }}</label>
                            <input type="text" name="two_factor_code" id="two_factor_code"
                                   class="input input-bordered w-full"
                                   required="" wire:model="two_factor_code">
                        </div>

                        <div class="flex items-center space-x-2 w-full">
                            <a href="/login"
                               class="btn btn-neutral w-1/2">
                                {{ __('Back') }}
                            </a>
                            <button type="submit"
                                    class="btn btn-primary w-1/2"
                                    wire:click="checkTwoFactorCode">
                                {{ __('Login') }}
                            </button>
                        </div>

                    @else
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="username">
                                    <span class="label-text">{{ __('Username') }}</span>
                                </label>
                                <input type="text" id="username"
                                       class="input input-bordered w-full" wire:model="username"
                                       wire:blur="checkIfUserExits($event.target.value)"/>
                            </div>
                        </div>
                        <div>
                            <div class="form-control w-full">
                                <label class="label" for="password">
                                    <span class="label-text">{{ __('Password') }}</span>
                                </label>
                                <input type="password" id="password"
                                       class="input input-bordered w-full" wire:model="password"/>
                            </div>
                        </div>
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <span class="label-text">{{ __('Remember me') }}</span>
                                <input type="checkbox" checked="checked" class="checkbox"
                                       wire:model="remember_me"/>
                            </label>
                        </div>
                        <button type="submit"
                                class="w-full btn btn-primary"
                                wire:click="attemptLogin">
                            {{ __('Login') }}
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="pl-6 pb-4" wire:ignore>
        <span class="text-sm" wire:ignore><a id="photo">{{ __('Photo') }}</a>, <a id="author"></a>, <a
                href="https://unaplash.com/utm_source=CyanFox&utm_medium=referral">Unsplash</a></span>
    </div>
</section>
