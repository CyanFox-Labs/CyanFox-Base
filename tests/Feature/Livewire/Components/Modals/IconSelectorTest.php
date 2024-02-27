<?php

namespace Tests\Feature\Livewire\Components\Modals;

use App\Livewire\Components\Modals\IconSelector;
use Livewire\Livewire;
use Tests\TestCase;

class IconSelectorTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(IconSelector::class)
            ->assertStatus(200);
    }
}
