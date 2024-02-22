<?php

namespace App\Livewire\Admin\Settings;

use App\Facades\SettingsManager;
use App\Models\Setting;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfileSettings extends Component
{

    public $options;

    public $defaultAvatarUrl;
    public $enableChangeAvatar;
    public $enableDeleteAccount;

    public function updateProfileSettings()
    {
        $this->validate([
            'defaultAvatarUrl' => 'required',
            'enableChangeAvatar' => 'required|boolean',
            'enableDeleteAccount' => 'required|boolean',
        ]);

        $settings = [
            'profile_default_avatar_url' => $this->defaultAvatarUrl,
            'profile_enable_change_avatar' => $this->enableChangeAvatar,
            'profile_enable_delete_account' => $this->enableDeleteAccount,
        ];

        SettingsManager::updateSettings($settings);

        activity()
            ->logName('admin')
            ->description('admin:settings.update')
            ->causer(Auth::user()->username)
            ->subject('profile-settings')
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->success()
            ->title(__('pages/admin/settings/settings.notifications.settings_updated'))
            ->send();

        $this->dispatch('refresh');
    }

    public function mount()
    {
        $this->options = [
            ['id' => '1', 'name' => __('messages.yes')],
            ['id' => '0', 'name' => __('messages.no')]
        ];

        $this->defaultAvatarUrl = setting('profile_default_avatar_url');
        $this->enableChangeAvatar = setting('profile_enable_change_avatar') ? 1 : 0;
        $this->enableDeleteAccount = setting('profile_enable_delete_account') ? 1 : 0;
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.settings.profile-settings');
    }
}
