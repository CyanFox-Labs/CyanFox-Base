<?php

namespace App\Livewire\Admin;

use App\Http\Controllers\VersionController;
use Livewire\Component;

class Admin extends Component
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
        $this->isDevVersion = VersionController::isDevVersion();
        $this->currentProjectVersion = VersionController::getCurrentProjectVersion();
        $this->currentTemplateVersion = VersionController::getCurrentTemplateVersion();
    }

    public function checkForUpdates()
    {
        $this->remoteProjectVersion = VersionController::getRemoteProjectVersion();
        $this->remoteTemplateVersion = VersionController::getRemoteTemplateVersion();
        $this->isProjectUpToDate = VersionController::isProjectUpToDate();
        $this->isTemplateUpToDate = VersionController::isTemplateUpToDate();
        $this->showUpdateNotification = true;

        activity('system')
            ->causedBy(auth()->user())
            ->withProperty('name', __('messages.system'))
            ->withProperty('ip', session()->get('ip_address'))
            ->log('check_for_updates');
    }

    public function render()
    {
        return view('livewire.admin.admin')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.dashboard')
            ]);
    }
}
