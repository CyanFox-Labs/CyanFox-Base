<?php

namespace App\Livewire\Admin;

use App\Facades\Utils\VersionManager;
use App\Helpers\VersionHelper;
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
    public $user;

    public function mount()
    {
        $this->isDevVersion = VersionManager::isDevVersion();
        $this->currentProjectVersion = VersionManager::getCurrentProjectVersion();
        $this->currentTemplateVersion = VersionManager::getCurrentTemplateVersion();
        $this->user = Auth::user();
    }

    public function checkForUpdates()
    {
        $this->remoteProjectVersion = VersionManager::getRemoteProjectVersion();
        $this->remoteTemplateVersion = VersionManager::getRemoteTemplateVersion();
        $this->isProjectUpToDate = VersionManager::isProjectUpToDate();
        $this->isTemplateUpToDate = VersionManager::isTemplateUpToDate();
        $this->showUpdateNotification = true;

        activity()
            ->logName('admin')
            ->description('admin:dashboard.check_for_updates')
            ->causer($this->user->username)
            ->subject('system')
            ->performedBy($this->user)
            ->save();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.admin.dashboard')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.dashboard')]);
    }
}
