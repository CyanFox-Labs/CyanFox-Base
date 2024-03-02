<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\SetupPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class SetupPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        Livewire::actingAs($user)
            ->test(SetupPassword::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_setup_password(): void
    {
        $user = User::factory()->create([
            'password' => null,
        ]);

        $password = fake()->password(8);

        Livewire::actingAs($user)
            ->test(SetupPassword::class)
            ->set('newPassword', $password)
            ->set('passwordConfirmation', $password)
            ->call('setupPassword');

        $this->assertTrue(Hash::check($password, $user->fresh()->password));
    }
}
