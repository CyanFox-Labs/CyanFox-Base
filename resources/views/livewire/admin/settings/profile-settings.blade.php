<div>
    <x-form wire:submit="updateProfileSettings">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(0,1fr))] gap-4 mb-5">
            <x-input label="{{ __('admin/settings.profile.default_avatar_url') }}" type="url" class="input-bordered"
                     wire:model="defaultAvatarUrl" hint="{{ __('admin/settings.profile.default_avatar_url_hint') }}" required/>

            <x-select label="{{ __('admin/settings.profile.enable_change_avatar') }}"
                      wire:model="enableChangeAvatar"
                      class="select select-bordered"
                      :options="$options"></x-select>

            <x-select label="{{ __('admin/settings.profile.enable_delete_account') }}"
                      wire:model="enableDeleteAccount"
                      class="select select-bordered"
                      :options="$options"></x-select>
        </div>


        <div class="divider"></div>

        <div class="mt-2 flex justify-start gap-3">
            <x-button class="btn btn-success"
                      type="submit" spinner="updateProfileSettings">
                {{ __('admin/settings.buttons.update_settings') }}
            </x-button>
        </div>
    </x-form>
</div>
