<?php

namespace Tests\Feature\Livewire\Account;

use App\Facades\UserManager;
use App\Livewire\Account\ForceChangePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ForceChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        $this->actingAs($user)->get(route('account.force-change.password'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        $newPassword = fake()->password(8);
        Livewire::actingAs($user)
            ->test(ForceChangePassword::class)
            ->set('currentPassword', 'password')
            ->set('newPassword', $newPassword)
            ->set('newPasswordConfirmation', $newPassword)
            ->call('changePassword');

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));

    }
}
