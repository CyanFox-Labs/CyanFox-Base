<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\AuthSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AuthSettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(AuthSettings::class)
            ->assertStatus(200);
    }
}
