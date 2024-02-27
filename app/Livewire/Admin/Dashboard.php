<?php

namespace App\Livewire\Admin;

use App\Facades\ActivityLogManager;
use App\Facades\Utils\VersionManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    public $currentProjectVersion;

    public $currentTemplateVersion;

    public $remoteProjectVersion;

    public $remoteTemplateVersion;

    public $isProjectUpToDate;

    public $isTemplateUpToDate;

    public $isDevVersion;

    public $showUpdateNotification = false;

    public function checkForUpdates(): void
    {
        $this->remoteProjectVersion = VersionManager::getRemoteProjectVersion();
        $this->remoteTemplateVersion = VersionManager::getRemoteTemplateVersion();
        $this->isProjectUpToDate = VersionManager::isProjectUpToDate();
        $this->isTemplateUpToDate = VersionManager::isTemplateUpToDate();
        $this->showUpdateNotification = true;

        ActivityLogManager::logName('admin')
            ->description('admin:dashboard.check_for_updates')
            ->causer(Auth::user()->username)
            ->subject('system')
            ->performedBy(Auth::user())
            ->save();
    }

    public function mount(): void
    {
        $this->isDevVersion = VersionManager::isDevVersion();
        $this->currentProjectVersion = VersionManager::getCurrentProjectVersion();
        $this->currentTemplateVersion = VersionManager::getCurrentTemplateVersion();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.dashboard')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.dashboard')]);
    }
}
