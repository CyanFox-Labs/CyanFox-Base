<?php

namespace Feature\Views\Admin;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AlertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_alert_admin_list(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $alert = Alert::factory()->create();
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-alert-list'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_alert_admin_create(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-alert-create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_alert_admin_edit(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $alert = Alert::factory()->create();
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-alert-edit', $alert->id));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_alerts(): void
    {
        $alert = Alert::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
    }
}
