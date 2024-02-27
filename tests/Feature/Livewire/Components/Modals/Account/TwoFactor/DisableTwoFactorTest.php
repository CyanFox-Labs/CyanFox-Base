<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\DisableTwoFactor;
use Livewire\Livewire;
use Tests\TestCase;

class DisableTwoFactorTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DisableTwoFactor::class)
            ->assertStatus(200);
    }
}
