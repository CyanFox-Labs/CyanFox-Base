<?php

namespace Tests\Feature\Livewire\Installer;

use App\Livewire\Installer\EmailSettings;
use Livewire\Livewire;
use Tests\TestCase;

class EmailSettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(EmailSettings::class)
            ->assertStatus(200);
    }
}
