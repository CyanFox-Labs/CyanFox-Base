<?php

namespace Tests\Feature\Livewire\Admin\Users;

use App\Livewire\Admin\Users\UpdateUser;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(UpdateUser::class)
            ->assertStatus(200);
    }
}
