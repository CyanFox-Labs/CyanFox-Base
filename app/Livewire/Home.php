<?php

namespace App\Livewire;

use App\Models\Alert;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Home extends Component
{

    public $alerts = [];

    public function mount()
    {
        $this->alerts = Alert::all()->sortByDesc('created_at');

    }

    function downloadFile($filePath, $fileName)
    {
        return response()->streamDownload(function () use ($filePath) {
            echo Storage::disk('public')->get($filePath);
        }, $fileName);
    }

    public function render()
    {
        return view('livewire.home')
            ->layout('components.layouts.app', [
                'title' => __('navigation/messages.home')
            ]);
    }
}
