<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\ProfileSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfileSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.settings', ['tab' => 'profile']))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_settings()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(ProfileSettings::class)
            ->set('defaultAvatarUrl', 'https://source.boringavatars.com/beam/120/{username}')
            ->set('enableChangeAvatar', true)
            ->set('enableDeleteAccount', true)
            ->call('updateProfileSettings');

        $this->assertDatabaseHas('settings', [
            'key' => 'profile_default_avatar_url',
            'value' => 'https://source.boringavatars.com/beam/120/{username}',
        ]);
    }
}
