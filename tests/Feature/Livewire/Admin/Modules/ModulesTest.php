<?php

namespace Tests\Feature\Livewire\Admin\Modules;

use App\Livewire\Admin\Modules\Modules;
use Livewire\Livewire;
use Tests\TestCase;

class ModulesTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Modules::class)
            ->assertStatus(200);
    }
}
