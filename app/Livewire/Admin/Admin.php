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

    public function mount()
    {
        $this->currentProjectVersion = VersionController::getCurrentProjectVersion();
        $this->currentTemplateVersion = VersionController::getCurrentTemplateVersion();
        $this->remoteProjectVersion = VersionController::getRemoteProjectVersion();
        $this->remoteTemplateVersion = VersionController::getRemoteTemplateVersion();
        $this->isProjectUpToDate = VersionController::isProjectUpToDate();
        $this->isTemplateUpToDate = VersionController::isTemplateUpToDate();
        $this->isDevVersion = VersionController::isDevVersion();
    }

    public function render()
    {
        return view('livewire.admin.admin')
            ->layout('components.layouts.admin', [
                'title' => __('navigation/titles.admin.dashboard')
            ]);
    }
}
