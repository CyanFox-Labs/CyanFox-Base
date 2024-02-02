<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Filament\Notifications\Notification;
use Livewire\Component;

class SecuritySettings extends Component
{

    public $passwordMinimumLength = 1;
    public $passwordMinimumLengthOptions;
    public $passwordRequireNumbers = false;
    public $passwordRequireSpecialCharacters = false;
    public $passwordRequireUppercase = false;
    public $passwordRequireLowercase = false;

    public function updateSecuritySettings()
    {

        $this->validate([
            'passwordMinimumLength' => 'required|numeric',
            'passwordRequireNumbers' => 'nullable|boolean',
            'passwordRequireSpecialCharacters' => 'nullable|boolean',
            'passwordRequireUppercase' => 'nullable|boolean',
            'passwordRequireLowercase' => 'nullable|boolean',
        ]);

        $settings = [
            'security_password_minimum_length' => $this->passwordMinimumLength,
            'security_password_require_numbers' => $this->passwordRequireNumbers,
            'security_password_require_special_characters' => $this->passwordRequireSpecialCharacters,
            'security_password_require_uppercase' => $this->passwordRequireUppercase,
            'security_password_require_lowercase' => $this->passwordRequireLowercase,
        ];

        foreach ($settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        Notification::make()
            ->success()
            ->title(__('pages/admin/settings/settings.notifications.settings_updated'))
            ->send();

        return redirect()->route('admin.settings', ['tab' => 'security']);
    }

    public function mount()
    {
        foreach (range(1, 20) as $number) {
            $this->passwordMinimumLengthOptions[$number] = ['id' => $number,
                'name' => __('pages/admin/settings/security_settings.password_minimum_length_options.' . $number)];
        }

        $this->passwordMinimumLength = setting('security_password_minimum_length');
        $this->passwordRequireNumbers = (bool) setting('security_password_require_numbers');
        $this->passwordRequireSpecialCharacters = (bool) setting('security_password_require_special_characters');
        $this->passwordRequireUppercase = (bool) setting('security_password_require_uppercase');
        $this->passwordRequireLowercase = (bool) setting('security_password_require_lowercase');
    }


    public function render()
    {
        return view('livewire.admin.settings.security-settings');
    }
}
