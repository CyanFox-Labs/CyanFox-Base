<?php

namespace Tests\Feature\Livewire\Admin\Users;

use App\Livewire\Admin\Users\UpdateUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.users.update', ['userId' => $user->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_update_user()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        $password = fake()->password(20);

        Livewire::actingAs($user)
            ->test(UpdateUser::class, ['userId' => $user->id])
            ->set('username', 'test')
            ->set('firstName', fake()->firstName)
            ->set('lastName', fake()->lastName)
            ->set('email', 'test@local.host')
            ->set('password', $password)
            ->set('passwordConfirmation', $password)
            ->call('updateUser');

        $this->assertDatabaseHas('users', [
            'username' => 'test',
            'email' => 'test@local.host',
        ]);
    }
}
