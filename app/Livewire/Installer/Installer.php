<?php

namespace App\Livewire\Installer;

use App\Facades\Utils\UnsplashManager;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Installer extends Component
{
    public $unsplash;

    public $language;

    #[Url]
    public $step = 'database';

    #[On('changeStep')]
    public function changeStep($step): void
    {
        $this->step = $step;

        $this->redirect(route('install', ['step' => $step]), navigate: true);
    }

    public function changeLanguage($language): void
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('messages.notifications.language_updated'))
            ->success()
            ->send();

        $this->redirect(route('install', ['step' => $this->step]), navigate: true);
    }

    public function mount(): void
    {
        if (!in_array($this->step, ['database', 'system', 'email', 'createUser'])) {
            $this->step = 'database';
        }

        $unsplash = UnsplashManager::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }

        $this->language = Request::cookie('language');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.installer.installer')
            ->layout('components.layouts.guest', ['title' => __('installer.tab_title')]);
    }
}
