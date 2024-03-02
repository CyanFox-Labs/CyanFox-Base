<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\AuthSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.settings', ['tab' => 'auth']))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_settings()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(AuthSettings::class)
            ->set('enableAuth', true)
            ->set('enableCaptcha', false)
            ->set('enableForgotPassword', true)
            ->set('enableRegistration', true)
            ->set('enableOAuth', true)
            ->set('enableLocalLogin', true)
            ->call('updateAuthSettings');

        $this->assertDatabaseHas('settings', [
            'key' => 'auth_enable',
            'value' => '1',
        ]);
    }
}
