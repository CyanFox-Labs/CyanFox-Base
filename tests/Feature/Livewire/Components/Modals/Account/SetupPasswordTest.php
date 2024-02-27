<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\SetupPassword;
use Livewire\Livewire;
use Tests\TestCase;

class SetupPasswordTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(SetupPassword::class)
            ->assertStatus(200);
    }
}
