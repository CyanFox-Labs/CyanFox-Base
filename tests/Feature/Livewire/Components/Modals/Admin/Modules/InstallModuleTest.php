<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Modules;

use App\Livewire\Components\Modals\Admin\Modules\InstallModule;
use Livewire\Livewire;
use Tests\TestCase;

class InstallModuleTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(InstallModule::class)
            ->assertStatus(200);
    }
}
