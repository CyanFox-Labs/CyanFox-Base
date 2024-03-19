<?php

namespace Tests\Feature\Livewire\Account;

use App\Facades\UserManager;
use App\Livewire\Account\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        $this->actingAs($user)->get(route('account.profile'))
            ->assertStatus(200);

        $this->actingAs($user)->get(route('account.profile', ['tab' => 'sessions']))
            ->assertStatus(200);

        $this->actingAs($user)->get(route('account.profile', ['tab' => 'apiKeys']))
            ->assertStatus(200);

        $this->actingAs($user)->get(route('account.profile', ['tab' => 'activity']))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_profile()
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);
        UserManager::getUser($user)->getTwoFactorManager()->generateTwoFactorSecret();

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('username', 'test')
            ->set('firstName', 'Test')
            ->set('lastName', 'User')
            ->set('email', 'test@local.host')
            ->set('theme', 'dark')
            ->set('language', 'de')
            ->set('currentPassword', 'password')
            ->set('password', 'kXqz=k^zwu7d^;UrMPNF')
            ->set('passwordConfirmation', 'kXqz=k^zwu7d^;UrMPNF')
            ->call('updateProfileInformations')
            ->call('updatePassword')
            ->call('updateLanguageAndTheme');

        $this->assertDatabaseHas('users', [
            'username' => 'test',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@local.host',
            'theme' => 'dark',
            'language' => 'de',
        ]);

    }
}
