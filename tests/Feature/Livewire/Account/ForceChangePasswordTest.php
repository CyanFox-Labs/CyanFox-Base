<?php

namespace Tests\Feature\Livewire\Account;

use App\Livewire\Account\ForceChangePassword;
use Livewire\Livewire;
use Tests\TestCase;

class ForceChangePasswordTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ForceChangePassword::class)
            ->assertStatus(200);
    }
}
