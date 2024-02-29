<?php

namespace App\Livewire\Admin\Settings;

use App\Facades\ActivityLogManager;
use App\Facades\SettingsManager;
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

    public function updateProfileSettings(): void
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

        ActivityLogManager::logName('admin')
            ->description('admin:settings.update')
            ->causer(Auth::user()->username)
            ->subject('profile-settings')
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->success()
            ->title(__('admin/settings.notifications.settings_updated'))
            ->send();

        $this->redirect(route('admin.settings', ['tab' => 'profile']), navigate: true);
    }

    public function mount(): void
    {
        $this->options = [
            ['id' => '1', 'name' => __('messages.yes')],
            ['id' => '0', 'name' => __('messages.no')],
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
