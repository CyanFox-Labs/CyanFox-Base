<?php

namespace Tests\Feature\Livewire\Components\Modals\Account\TwoFactor;

use App\Facades\UserManager;
use App\Livewire\Components\Modals\Account\TwoFactor\DisableTwoFactor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class DisableTwoFactorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        Livewire::actingAs($user)
            ->test(DisableTwoFactor::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_disable_two_factor()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        Livewire::actingAs($user)
            ->test(DisableTwoFactor::class)
            ->set('password', 'password')
            ->call('disableTwoFactor');

        $this->assertTrue($user->fresh()->two_factor_enabled === 0);
    }
}
