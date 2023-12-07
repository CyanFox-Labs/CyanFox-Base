<?php

namespace Tests\Feature\Livewire\Account;

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\Account\Profile;
use App\Livewire\Components\Modals\Profile\ActivateTwoFactor;
use App\Livewire\Components\Modals\Profile\DisableTwoFactor;
use App\Livewire\Components\Modals\Profile\LogoutAllSessions;
use App\Livewire\Components\Modals\Profile\LogoutSession;
use App\Livewire\Components\Modals\Profile\NewApiKey;
use App\Livewire\Components\Modals\Profile\RecoveryCodes;
use App\Livewire\Components\Modals\Profile\RevokeApiKey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('first_name', 'test')
            ->set('last_name', 'test')
            ->set('username', 'test')
            ->set('email', 'test@local.host')
            ->call('updateProfile')
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('current_password', 'password')
            ->set('new_password', 'new_password')
            ->set('confirm_password', 'new_password')
            ->call('updatePassword')
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_change_language(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->call('changeLanguage', 'en')
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_change_theme(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->call('changeTheme', 'dark')
            ->assertRedirect(route('profile'));

    }


    /** @test */
    public function user_can_revoke_session(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        DB::table('sessions')->insert([
            'id' => 'test',
            'user_id' => $user->id,
            'ip_address' => '0.0.0.0',
            'user_agent' => 'test',
            'payload' => 'test',
            'last_activity' => 0,
        ]);


        Livewire::actingAs($user)
            ->test(LogoutSession::class)
            ->set('sessionId', 'test')
            ->set('password', 'password')
            ->call('logoutSession')
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_revoke_all_sessions(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        DB::table('sessions')->insert([
            'id' => 'test',
            'user_id' => $user->id,
            'ip_address' => '0.0.0.0',
            'user_agent' => 'test',
            'payload' => 'test',
            'last_activity' => 0,
        ]);


        Livewire::actingAs($user)
            ->test(LogoutAllSessions::class)
            ->set('password', 'password')
            ->call('logoutAllSessions')
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_activate_two_factor(): void
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
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_disable_two_factor(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        Livewire::actingAs($user)
            ->test(DisableTwoFactor::class)
            ->set('password', 'password')
            ->call('disableTwoFactor')
            ->assertRedirect(route('profile'));

    }

    /** @test */
    public function user_can_view_recovery_codes(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        AuthController::generateRecoveryCodes($user);

        Livewire::actingAs($user)
            ->test(RecoveryCodes::class)
            ->set('password', 'password')
            ->call('showRecoveryCodes')
            ->assertDispatched('openModal');

    }

    /** @test */
    public function user_can_create_an_api_key()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $component = new NewApiKey();
        $component->name = 'Test API Key';
        $component->createAPIKey();

        $this->assertNotNull($component->plainTextToken);
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'Test API Key',
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user)
        ]);
    }

    /** @test */
    public function user_can_revoke_an_api_key()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tokenString = Str::random(80);

        $apiKey = $user->tokens()->create([
            'name' => 'Test API Key',
            'token' => hash('sha256', $tokenString),
        ]);

        $component = new RevokeApiKey();
        $component->apiKey = $apiKey->id;
        $component->revokeApiKey();

        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $apiKey->id]);
    }
}
