<?php

namespace Tests\Feature\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        $this->actingAs($user)->get(route('admin.users'))
            ->assertStatus(200);
    }
}
