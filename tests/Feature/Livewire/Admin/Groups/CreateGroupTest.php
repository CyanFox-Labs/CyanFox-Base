<?php

namespace Tests\Feature\Livewire\Admin\Groups;

use App\Livewire\Admin\Groups\CreateGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        $this->actingAs($user)->get(route('admin.groups.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_create_group()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);

        Livewire::actingAs($user)
            ->test(CreateGroup::class)
            ->set('name', 'test')
            ->set('guardName', 'web')
            ->call('createGroup');

        $this->assertDatabaseHas('roles', [
            'name' => 'test',
            'guard_name' => 'web',
        ]);
    }
}
