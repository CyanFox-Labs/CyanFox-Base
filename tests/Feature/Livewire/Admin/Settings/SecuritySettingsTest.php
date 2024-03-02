<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\SecuritySettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SecuritySettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.settings', ['tab' => 'security']))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_settings()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole($role);

        Livewire::actingAs($user)
            ->test(SecuritySettings::class)
            ->set('passwordMinimumLength', 8)
            ->set('passwordRequireLowercase', true)
            ->set('passwordRequireUppercase', true)
            ->set('passwordRequireNumbers', true)
            ->set('passwordRequireSpecialCharacters', false)
            ->call('updateSecuritySettings');

        $this->assertDatabaseHas('settings', [
            'key' => 'security_password_minimum_length',
            'value' => 8,
        ]);
    }
}
