<?php

namespace Tests\Feature\Livewire\Admin;

use App\Livewire\Admin\Users\UserCreate;
use App\Livewire\Admin\Users\UserEdit;
use App\Livewire\Components\Modals\Admin\UserDelete;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_users(): void
    {
        $role = Role::create(['name' => 'test']);

        Livewire::test(UserCreate::class)
            ->set('first_name', 'test')
            ->set('last_name', 'test')
            ->set('email', 'test@local.host')
            ->set('username', 'test')
            ->set('password', 'password')
            ->set('password', 'password')
            ->set('change_password', true)
            ->set('activate_two_factor', true)
            ->set('roles', [$role->id])
            ->call('createUser')
            ->assertRedirect(route('admin-user-list'));

    }

    /** @test */
    public function user_can_edit_users(): void
    {
        $role = Role::create(['name' => 'test']);
        $user = User::factory()->create();

        Livewire::test(UserEdit::class, ['userId' => $user->id])
            ->set('first_name', 'test')
            ->set('last_name', 'test')
            ->set('email', 'test@local.host')
            ->set('username', 'test')
            ->set('password', 'password')
            ->set('password', 'password')
            ->set('change_password', true)
            ->set('activate_two_factor', true)
            ->set('roles', [$role->id])
            ->call('updateUser')
            ->assertRedirect(route('admin-user-list'));

    }

    /** @test */
    public function user_can_delete_users(): void
    {
        $user = User::factory()->create();

        Livewire::test(UserDelete::class)
            ->set('userId', $user->id)
            ->call('deleteUser')
            ->assertRedirect(route('admin-user-list'));

    }
}
