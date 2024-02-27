<?php

namespace Tests\Feature\Livewire\Account;

use App\Livewire\Account\ForceActivateTwoFactor;
use Livewire\Livewire;
use Tests\TestCase;

class ForceActivateTwoFactorTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ForceActivateTwoFactor::class)
            ->assertStatus(200);
    }
}
