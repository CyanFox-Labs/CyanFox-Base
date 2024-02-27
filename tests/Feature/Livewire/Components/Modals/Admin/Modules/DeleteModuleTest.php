<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Modules;

use App\Livewire\Components\Modals\Admin\Modules\DeleteModule;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteModuleTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DeleteModule::class)
            ->assertStatus(200);
    }
}
