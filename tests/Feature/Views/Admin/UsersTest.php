<?php

namespace Tests\Feature\Views\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_admin_users_list(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-user-list'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_admin_users_create(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-user-create'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_view_admin_users_edit(): void
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->get(route('admin-user-edit', $user->id));

        $response->assertStatus(200);
    }
}
