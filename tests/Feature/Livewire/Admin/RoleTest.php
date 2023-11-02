<?php

namespace Tests\Feature\Livewire\Admin;

use App\Livewire\Admin\Roles\RoleCreate;
use App\Livewire\Admin\Roles\RoleEdit;
use App\Livewire\Components\Modals\Admin\RoleDelete;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_roles(): void
    {
        $permission = Permission::create(['name' => 'test']);

        Livewire::test(RoleCreate::class)
            ->set('name', 'test')
            ->set('guard_name', 'web')
            ->set('permissions', [$permission->id])
            ->call('createRole')
            ->assertRedirect(route('admin-role-list'));

    }

    /** @test */
    public function user_can_edit_roles(): void
    {
        $permission = Permission::create(['name' => 'test']);
        $role = Role::create(['name' => 'test']);

        Livewire::test(RoleEdit::class, ['roleId' => $role->id])
            ->set('name', 'test')
            ->set('guard_name', 'web')
            ->set('permissions', [$permission->id])
            ->call('updateRole')
            ->assertRedirect(route('admin-role-list'));

    }

    /** @test */
    public function user_can_delete_roles(): void
    {
        $role = Role::create(['name' => 'test']);

        Livewire::test(RoleDelete::class)
            ->set('roleId', $role->id)
            ->call('deleteRole')
            ->assertRedirect(route('admin-role-list'));

    }
}
