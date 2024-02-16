<div>
    <x-form wire:submit="saveSystemSettings">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] gap-4 mb-5">
            <x-input label="{{ __('pages/installer.system.app_name') }}" class="input-bordered" wire:model="appName"/>
            <x-input label="{{ __('pages/installer.system.app_url') }}" class="input-bordered" wire:model="appUrl"/>
            <x-select label="{{ __('pages/installer.system.app_lang') }}"
                      wire:model="appLang"
                      class="select select-bordered"
                      :options="[
                    ['id' => 'en', 'name' => __('messages.languages.english')],
                    ['id' => 'de', 'name' => __('messages.languages.german')]]"></x-select>
            <x-select label="{{ __('pages/installer.system.app_timezone') }}"
                      wire:model="appTimezone"
                      class="select select-bordered"
                      :options="$timeZones"></x-select>

        </div>

        <div class="divider"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-5">
            <x-input label="{{ __('pages/installer.system.unsplash_utm') }}" class="input-bordered" wire:model="unsplashUtm"/>
            <x-input label="{{ __('pages/installer.system.unsplash_api_key') }}" class="input-bordered" type="password" wire:model="unsplashApiKey"/>
        </div>

        <div class="divider"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-5">
            <x-input label="{{ __('pages/installer.system.project_version_url') }}" type="url" class="input-bordered" wire:model="projectVersionUrl"/>
            <x-input label="{{ __('pages/installer.system.template_version_url') }}" type="url" class="input-bordered"
                     wire:model="templateVersionUrl"/>
            <x-input label="{{ __('pages/installer.system.icon_url') }}" type="url" class="input-bordered"
                     wire:model="iconUrl"/>
        </div>

        <div class="divider"></div>

        <div class="mt-2 flex justify-between gap-3">
            <x-button class="btn btn-neutral"
                      type="button" wire:click="$dispatch('changeStep', ['database'])" spinner>
                {{ __('pages/installer.buttons.back') }}
            </x-button>
            <x-button class="btn btn-success"
                      type="submit" spinner="saveSystemSettings">
                {{ __('pages/installer.buttons.next') }}
            </x-button>
        </div>
    </x-form>
</div>
