<div class="flex flex-col justify-between relative min-h-screen">
    <div class="absolute inset-0 z-[-1]" style="{{ $unsplash['css'] }}"></div>
    <div class="flex flex-col md:justify-center md:items-center">
        <p class="flex items-center justify-center mb-6 text-2xl font-semibold">
            <img class="w-32 h-32" src="{{ asset("img/Logo.svg") }}" alt="Logo">
            <span
                class="text-4xl font-bold brand-text text-white lg:block hidden">{{ config('app.name') }}</span>
        </p>

        <div
            class="card bg-base-200 lg:w-1/2 sm:min-w-96 sm:w-1/8 w-auto">
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

                <div role="tablist" class="tabs tabs-boxed mb-5">
                    <a role="tab" class="cursor-default tab @if($step == 'database') tab-active @endif">{{ __('pages/installer.tabs.database') }}</a>
                    <a role="tab" class="cursor-default tab @if($step == 'system') tab-active @endif">{{ __('pages/installer.tabs.system') }}</a>
                    <a role="tab" class="cursor-default tab @if($step == 'email') tab-active @endif">{{ __('pages/installer.tabs.email') }}</a>
                    <a role="tab" class="cursor-default tab @if($step == 'createUser') tab-active @endif">{{ __('pages/installer.tabs.create_user') }}</a>
                </div>

                @if($step == 'database')
                    <livewire:installer.database-settings/>
                @endif

                @if($step == 'system')
                    <livewire:installer.system-settings/>
                @endif

                @if($step == 'email')
                    <livewire:installer.email-settings/>
                @endif

                @if($step == 'createUser')
                    <livewire:installer.create-user/>
                @endif
            </div>
        </div>

    </div>
    @if($unsplash['error'] == null)
        <div class="pl-6 pb-4 text-white">
            <span class="text-sm" id="credits" wire:ignore><a id="photo"
                                                              href="{{ $unsplash['photo'] }}/{{ config('template.unsplash.utm') }}">{{ __('pages/auth/messages.photo') }}</a>, <a
                    id="author"
                    href="{{ $unsplash['authorURL'] }}/{{ config('template.unsplash.utm') }}">{{ $unsplash['author'] }}</a>, <a
                    href="https://unsplash.com/{{ config('template.unsplash.utm') }}">Unsplash</a></span>
        </div>
    @endif
</div>
