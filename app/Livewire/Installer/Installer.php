<?php

namespace App\Livewire\Installer;

use App\Helpers\UnsplashHelper;
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
    public function changeStep($step)
    {
        $this->step = $step;

        return redirect(route('installer') . '?step=' . $step);
    }

    public function mount()
    {
        if (!in_array($this->step, ['database', 'system', 'email', 'createUser'])) {
            $this->step = 'database';
        }

        $unsplash = UnsplashHelper::returnBackground();

        $this->unsplash = $unsplash;

        if ($unsplash['error'] != null) {
            $this->dispatch('logger', ['type' => 'error', 'message' => $unsplash['error']]);
        }

        $this->language = Request::cookie('language');
    }

    public function changeLanguage($language)
    {
        cookie()->queue(cookie()->forget('language'));
        cookie()->queue(cookie()->forever('language', $language));

        Notification::make()
            ->title(__('pages/auth/messages.notifications.language_changed'))
            ->success()
            ->send();

        $this->dispatch('refresh');
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.installer.installer')
            ->layout('components.layouts.guest', ['title' => __('navigation/titles.install')]);
    }
}
