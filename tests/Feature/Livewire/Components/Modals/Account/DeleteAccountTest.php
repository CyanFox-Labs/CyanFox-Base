<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\DeleteAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(DeleteAccount::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_delete_account()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        Livewire::actingAs($user)
            ->test(DeleteAccount::class)
            ->set('password', 'password')
            ->call('deleteAccount');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
