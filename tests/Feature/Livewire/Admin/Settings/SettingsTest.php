<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Settings::class)
            ->assertStatus(200);
    }
}
