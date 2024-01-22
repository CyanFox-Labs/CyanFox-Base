<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\ShowRecoveryCodes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
