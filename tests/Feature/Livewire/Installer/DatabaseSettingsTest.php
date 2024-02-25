<?php

namespace Tests\Feature\Livewire\Installer;

use App\Livewire\Installer\DatabaseSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DatabaseSettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DatabaseSettings::class)
            ->assertStatus(200);
    }
}