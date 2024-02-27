<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\DeleteAccount;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DeleteAccount::class)
            ->assertStatus(200);
    }
}
