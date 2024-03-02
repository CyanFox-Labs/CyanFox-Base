<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Modules;

use App\Livewire\Components\Modals\Admin\Modules\DeleteModule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function renders_successfully()
    {
        $user = User::factory()->create();
        $group = Role::create(['name' => 'Super Admin']);
        $user->assignRole($group);
        Livewire::actingAs($user)
            ->test(DeleteModule::class)
            ->assertStatus(200);
    }
}
