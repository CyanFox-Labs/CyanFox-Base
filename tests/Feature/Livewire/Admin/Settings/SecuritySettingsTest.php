<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\SecuritySettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SecuritySettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(SecuritySettings::class)
            ->assertStatus(200);
    }
}
