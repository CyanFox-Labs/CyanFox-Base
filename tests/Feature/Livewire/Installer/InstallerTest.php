<?php

namespace Tests\Feature\Livewire\Installer;

use App\Livewire\Installer\Installer;
use Livewire\Livewire;
use Tests\TestCase;

class InstallerTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Installer::class)
            ->assertStatus(200);
    }
}
