<?php

namespace Tests\Feature\Livewire\Account;

use App\Facades\UserManager;
use App\Livewire\Account\ForceActivateTwoFactor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class ForceActivateTwoFactorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_activate_two_factor()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        $twoFactor = new Google2FA();
        $twoFactorCode = $twoFactor->getCurrentOtp(decrypt($user->two_factor_secret));

        Livewire::actingAs($user)
            ->test(ForceActivateTwoFactor::class)
            ->set('password', 'password')
            ->set('twoFactorCode', $twoFactorCode)
            ->call('activateTwoFactor');

        $this->assertTrue($user->fresh()->two_factor_enabled === 1);
    }
}
