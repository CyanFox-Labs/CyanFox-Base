<?php

namespace Tests\Feature\Livewire\Admin\Users;

use App\Livewire\Admin\Users\CreateUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateUser::class)
            ->assertStatus(200);
    }
}
