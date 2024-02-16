<?php

namespace Tests\Feature\Livewire\Installer;

use App\Livewire\Installer\EmailSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
