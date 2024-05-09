<?php

namespace App\Livewire\Admin\Settings;

use App\Facades\ActivityLogManager;
use App\Facades\SettingsManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class SystemSettings extends Component
{
    use WithFileUploads;

    public $timeZones = [];

    public $appName;

    public $appUrl;

    public $appLang;

    public $appTimezone;

    public $unsplashUtm;

    public $unsplashApiKey;

    public $projectVersionUrl;

    public $templateVersionUrl;

    public $iconUrl;

    public $logo;

    public function updateSystemSettings(): void
    {

        $this->validate([
            'appName' => 'nullable',
            'appUrl' => 'nullable|url',
            'appLang' => 'nullable',
            'appTimezone' => 'nullable',
            'unsplashUtm' => 'nullable',
            'unsplashApiKey' => 'nullable',
            'projectVersionUrl' => 'nullable|url',
            'templateVersionUrl' => 'nullable|url',
            'iconUrl' => 'nullable|url',
            'logo' => 'nullable|image|max:1024',
        ]);

        $settings = [
            'app_name' => $this->appName,
            'app_url' => $this->appUrl,
            'app_lang' => $this->appLang,
            'app_timezone' => $this->appTimezone,
            'unsplash_utm' => $this->unsplashUtm,
            'unsplash_api_key' => $this->unsplashApiKey ? encrypt($this->unsplashApiKey) : null,
            'project_version_url' => $this->projectVersionUrl,
            'template_version_url' => $this->templateVersionUrl,
            'icon_url' => $this->iconUrl,
        ];

        if ($this->logo) {
            $this->logo->storeAs('public', 'img/Logo.png');
            $settings['logo_path'] = 'storage/img/Logo.png';
        }

        SettingsManager::updateSettings($settings);

        ActivityLogManager::logName('admin')
            ->description('admin:settings.update')
            ->causer(Auth::user()->username)
            ->subject('system-settings')
            ->performedBy(Auth::user())
            ->save();

        Notification::make()
            ->success()
            ->title(__('admin/settings.notifications.settings_updated'))
            ->send();

        $this->redirect(route('admin.settings', ['tab' => 'settings']), navigate: true);
    }

    public function resetLogo()
    {
        Storage::disk('public')->delete('img/Logo.png');

        SettingsManager::updateSetting('logo_path', 'img/Logo.svg');

        ActivityLogManager::logName('admin')
            ->description('admin:settings.update')
            ->causer(Auth::user()->username)
            ->subject('system-settings')
            ->performedBy(Auth::user())
            ->save();

        $this->redirect(route('admin.settings', ['tab' => 'settings']), navigate: true);

    }

    public function mount(): void
    {

        /* Timezones */
        $timeZones = timezone_identifiers_list();
        $results = [];
        foreach ($timeZones as $timeZone) {
            if ($timeZone === setting('app_timezone')) {
                $results[] = ['id' => $timeZone, 'name' => $timeZone, 'selected' => true];
            } else {
                $results[] = ['id' => $timeZone, 'name' => $timeZone];
            }
        }

        $this->timeZones = $results;

        /* App Settings */
        $this->appName = setting('app_name');
        $this->appUrl = setting('app_url');
        $this->appLang = setting('app_lang');
        $this->appTimezone = setting('app_timezone');

        /* Unsplash Settings */
        $this->unsplashUtm = setting('unsplash_utm');
        $this->unsplashApiKey = setting('unsplash_api_key', true);

        /* URL Settings */
        $this->projectVersionUrl = setting('project_version_url');
        $this->templateVersionUrl = setting('template_version_url');
        $this->iconUrl = setting('icon_url');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.settings.system-settings');
    }
}
