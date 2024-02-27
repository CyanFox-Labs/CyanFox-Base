<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\ProfileSettings;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileSettingsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ProfileSettings::class)
            ->assertStatus(200);
    }
}
