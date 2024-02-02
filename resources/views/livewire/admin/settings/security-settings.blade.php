<div>
    <x-form wire:submit="updateSecuritySettings">
        @csrf
        <div class="mb-5">
            <x-select label="{{ __('pages/admin/settings/security_settings.password_minimum_length') }}"
                      wire:model="passwordMinimumLength"
                      class="select select-bordered"
                      :options="$passwordMinimumLengthOptions"></x-select>
        </div>

        <div class="space-y-5">
            <x-checkbox label="{{ __('pages/admin/settings/security_settings.password_require_lowercase') }}"
                        wire:model="passwordRequireLowercase" class="checkbox-info" left tight/>

            <x-checkbox label="{{ __('pages/admin/settings/security_settings.password_require_uppercase') }}"
                        wire:model="passwordRequireUppercase" class="checkbox-info" left tight/>

            <x-checkbox label="{{ __('pages/admin/settings/security_settings.password_require_numbers') }}"
                        wire:model="passwordRequireNumbers" class="checkbox-info" left tight/>

            <x-checkbox label="{{ __('pages/admin/settings/security_settings.password_require_special_characters') }}"
                        wire:model="passwordRequireSpecialCharacters" class="checkbox-info" left tight/>
        </div>

        <div class="divider"></div>

        <div class="mt-2 flex justify-start gap-3">
            <x-button class="btn btn-success"
                      type="submit" spinner="updateSecuritySettings">
                {{ __('messages.buttons.update') }}
            </x-button>
        </div>
    </x-form>
</div>
