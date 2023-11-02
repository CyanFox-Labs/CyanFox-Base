<?php

namespace Tests\Feature\Livewire\Account;

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\Account\ActivateTwoFactor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class ActivateTwoFactorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_user_activate_two_factor(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        AuthController::generateTwoFactorSecret($user);
        $two_factor = new Google2FA();
        $two_factor_code = $two_factor->getCurrentOtp(decrypt($user->two_factor_secret));

        Livewire::actingAs($user)
            ->test(ActivateTwoFactor::class)
            ->set('two_factor_code', $two_factor_code)
            ->set('password', 'password')
            ->call('activateTwoFactor')
            ->assertRedirect(route('home'));

    }
}
