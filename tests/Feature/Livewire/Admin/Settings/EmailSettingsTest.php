<?php

namespace Tests\Feature\Livewire\Admin\Settings;

use App\Livewire\Admin\Settings\EmailSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmailSettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.settings', ['tab' => 'emails']))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_settings()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(EmailSettings::class)
            ->set('welcomeEmailTitle', 'Welcome to {appName}')
            ->set('welcomeEmailSubject', 'Welcome to {appName}')
            ->call('updateEmailSettings');

        $this->assertDatabaseHas('settings', [
            'key' => 'emails_welcome_title',
            'value' => 'Welcome to {appName}',
        ]);
    }
}
