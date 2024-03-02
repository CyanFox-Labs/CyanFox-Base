<?php

namespace Tests\Feature\Livewire\Components\Modals\TwoFactor\Account;

use App\Facades\UserManager;
use App\Livewire\Components\Modals\Account\TwoFactor\ShowRecoveryCodes;
use App\Models\User;
use App\Models\UserRecoveryCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ShowRecoveryCodesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();
        UserManager::getUser($user)->getTwoFactorManager()->generateRecoveryCodes();

        Livewire::actingAs($user)
            ->test(ShowRecoveryCodes::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_user_show_recovery_codes()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();
        UserManager::getUser($user)->getTwoFactorManager()->generateRecoveryCodes();

        $recoveryCodes = UserRecoveryCode::where('user_id', $user->id)->get()->pluck('code')->toArray();
        $recoveryCodes = array_map('decrypt', $recoveryCodes);

        Livewire::actingAs($user)
            ->test(ShowRecoveryCodes::class)
            ->set('password', 'password')
            ->call('showRecoveryCodes')
            ->assertSet('recoveryCodes', $recoveryCodes);
    }
}
