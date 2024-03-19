<?php

namespace Tests\Feature\Livewire\Admin\Users;

use App\Livewire\Admin\Users\CreateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.users.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_create_user()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(CreateUser::class)
            ->set('username', 'test')
            ->set('firstName', 'TestUser')
            ->set('lastName', 'TestUser')
            ->set('email', 'test@local.host')
            ->set('password', 'kXqz=k^zwu7d^;UrMPNF')
            ->set('passwordConfirmation', 'kXqz=k^zwu7d^;UrMPNF')
            ->call('createUser');

        $this->assertDatabaseHas('users', [
            'username' => 'test',
            'email' => 'test@local.host',
        ]);
    }
}
