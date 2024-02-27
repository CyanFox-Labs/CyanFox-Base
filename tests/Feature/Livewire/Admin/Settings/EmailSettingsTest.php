<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\EmailSettings;
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
