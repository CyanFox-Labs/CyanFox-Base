<?php

namespace Tests\Feature\Livewire\Admin\Users;

use App\Livewire\Admin\Users\Users;
use Livewire\Livewire;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Users::class)
            ->assertStatus(200);
    }
}
