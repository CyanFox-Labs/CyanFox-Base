<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\ShowRecoveryCodes;
use Livewire\Livewire;
use Tests\TestCase;

class ShowRecoveryCodesTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ShowRecoveryCodes::class)
            ->assertStatus(200);
    }
}
