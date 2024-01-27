<?php

namespace App\Livewire\Admin;

use App\Helpers\VersionHelper;
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

    public function mount()
    {
        $this->isDevVersion = VersionHelper::isDevVersion();
        $this->currentProjectVersion = VersionHelper::getCurrentProjectVersion();
        $this->currentTemplateVersion = VersionHelper::getCurrentTemplateVersion();
    }

    public function checkForUpdates()
    {
        $this->remoteProjectVersion = VersionHelper::getRemoteProjectVersion();
        $this->remoteTemplateVersion = VersionHelper::getRemoteTemplateVersion();
        $this->isProjectUpToDate = VersionHelper::isProjectUpToDate();
        $this->isTemplateUpToDate = VersionHelper::isTemplateUpToDate();
        $this->showUpdateNotification = true;
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('components.layouts.admin', ['title' => __('navigation/titles.admin.dashboard')]);
    }
}
