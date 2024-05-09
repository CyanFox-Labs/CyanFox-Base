<div>
    <x-form wire:submit="updateSystemSettings">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] gap-4 mb-5">
            <x-input label="{{ __('admin/settings.system.app_name') }}" class="input-bordered" wire:model="appName"/>
            <x-input label="{{ __('admin/settings.system.app_url') }}" class="input-bordered" wire:model="appUrl"/>
            <x-select label="{{ __('admin/settings.system.app_lang') }}"
                      wire:model="appLang"
                      class="select select-bordered"
                      :options="[
                    ['id' => 'en', 'name' => __('messages.languages.en')],
                    ['id' => 'de', 'name' => __('messages.languages.de')]]"></x-select>
            <x-select label="{{ __('admin/settings.system.app_timezone') }}"
                      wire:model="appTimezone"
                      class="select select-bordered"
                      :options="$timeZones"></x-select>

        </div>

        <div class="divider"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-5">
            <x-input label="{{ __('admin/settings.system.unsplash_utm') }}" class="input-bordered"
                     wire:model="unsplashUtm"/>
            <x-input label="{{ __('admin/settings.system.unsplash_api_key') }}" type="password" class="input-bordered"
                     wire:model="unsplashApiKey"/>
        </div>

        <div class="divider"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-5">
            <x-input label="{{ __('admin/settings.system.project_version_url') }}" type="url" class="input-bordered"
                     wire:model="projectVersionUrl"/>
            <x-input label="{{ __('admin/settings.system.template_version_url') }}" type="url" class="input-bordered"
                     wire:model="templateVersionUrl"/>
            <x-input label="{{ __('admin/settings.system.icon_url') }}" type="url" class="input-bordered"
                     wire:model="iconUrl"/>

            <div class="lg:flex lg:space-x-2 overflow-x-auto">
                <x-file label="{{ __('admin/settings.system.logo') }}" wire:model="logo" accept="image/png"/>
                <x-button wire:click="resetLogo" class="btn btn-error mt-8" spinner>
                    {{ __('admin/settings.buttons.reset_logo') }}
                </x-button>
            </div>
        </div>

        <div class="divider"></div>

        <div class="mt-2 flex justify-start gap-3">
            <x-button class="btn btn-success"
                      type="submit" spinner="updateSystemSettings">
                {{ __('admin/settings.buttons.update_settings') }}
            </x-button>
        </div>
    </x-form>
</div>
