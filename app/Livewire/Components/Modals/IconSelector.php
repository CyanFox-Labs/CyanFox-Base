<?php

namespace App\Livewire\Components\Modals;

use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class IconSelector extends ModalComponent
{
    public $icons;
    public $search;
    private $data;

    function setIcon($icon)
    {
        if(!in_array($icon, $this->icons)) {
            return;
        }

        $this->closeModal();
        $this->dispatch('updateIcon', $icon);
    }

    function getIcons(): array
    {
        $icons = array_keys($this->data);
        return array_map(function($icon) {
            return 'icon-' . $icon;
        }, $icons);
    }

    function searchIcon(): array
    {
        $results = [];
        $searchTerm = $this->search;
        $strJsonFileContents = file_get_contents(setting('icon_url'));
        $this->data = json_decode($strJsonFileContents, true);

        $searchTerm = str_replace(' ', '-', strtolower($searchTerm));

        foreach ($this->data as $icon => $categories) {
            if(strpos($icon, $searchTerm) !== false) {
                $results[] = 'icon-' . $icon;
                continue;
            }

            foreach ($categories as $category) {
                if(strpos($category, $searchTerm) !== false) {
                    $results[] = 'icon-' . $icon;
                    break;
                }
            }
        }

        $this->icons = $results;
        return $results;
    }

    public function mount()
    {
        $strJsonFileContents = file_get_contents(setting('icon_url'));
        $this->data = json_decode($strJsonFileContents, true);

        $this->icons = $this->getIcons();
    }

    #[On('refresh')]
    public function render()
    {
        return view('livewire.components.modals.icon-selector');
    }
}
