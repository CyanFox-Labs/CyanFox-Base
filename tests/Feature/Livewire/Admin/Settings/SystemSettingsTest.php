<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\SystemSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SystemSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.settings', ['tab' => 'system']))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_settings()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(SystemSettings::class)
            ->set('appName', 'Test App')
            ->set('appUrl', 'http://test.local')
            ->set('appTimezone', 'UTC')
            ->set('appLang', 'en')
            ->set('unsplashUtm', '?utm_source=Test&utm_medium=referral')
            ->set('unsplashApiKey', '')
            ->set('projectVersionUrl', 'https://raw.githubusercontent.com/CyanFox-Projects/Laravel-Template/v2/version.json')
            ->set('templateVersionUrl', 'https://raw.githubusercontent.com/CyanFox-Projects/Laravel-Template/v2/version.json')
            ->set('iconUrl', 'https://raw.githubusercontent.com/CyanFox-Projects/Data/main/icons.json')
            ->call('updateSystemSettings');

        $this->assertDatabaseHas('settings', [
            'key' => 'app_name',
            'value' => 'Test App',
        ]);
    }
}
