<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\ActivateTwoFactor;
use Livewire\Livewire;
use Tests\TestCase;

class ActivateTwoFactorTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ActivateTwoFactor::class)
            ->assertStatus(200);
    }
}
