<?php

namespace Tests\Feature\Livewire\Installer;

use App\Livewire\Installer\SystemSettings;
use Livewire\Livewire;
use Tests\TestCase;

class SystemSettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(SystemSettings::class)
            ->assertStatus(200);
    }
}
