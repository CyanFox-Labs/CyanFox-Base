<?php

namespace Tests\Feature\Views\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_admin_role_list(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-role-list'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_admin_role_create(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-role-create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_admin_role_edit(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-role-edit', $role->id));

        $response->assertStatus(200);
    }
}
