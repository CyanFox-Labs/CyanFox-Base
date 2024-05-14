<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col md:justify-center md:items-center">
        <p class="flex items-center justify-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32" src="{{ asset(setting('logo_path')) }}" alt="Logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden">{{ setting('app_name') }}</span>
        </p>
        <div class="card bg-base-200 lg:w-1/3 sm:min-w-96 sm:w-1/8 w-auto">
            <div class="card-body">

                <x-form class="" wire:submit="changePassword">
                    @csrf

                    <x-input label="{{ __('messages.current_password') }}"
                             type="password"
                             class="input-bordered w-full" wire:model="currentPassword" required/>


                    <div class="grid lg:grid-cols-2 gap-4 mt-4">
                        <x-input label="{{ __('messages.new_password') }}"
                                 type="password"
                                 class="input-bordered w-full" wire:model="newPassword" required/>

                        <x-input label="{{ __('messages.confirm_password') }}"
                                 type="password"
                                 class="input-bordered w-full" wire:model="newPasswordConfirmation" required/>
                    </div>

                    <div class="divider"></div>

                    <div class="flex">
                        <x-button type="submit"
                                  class="flex-1 mr-2 btn btn-primary" spinner="changePassword">
                            {{ __('account/force_activate.force_change_password.buttons.change_password') }}
                        </x-button>
                    </div>
                </x-form>
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
