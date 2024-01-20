<?php

namespace Tests\Feature\Livewire\Components\Modals\Account;

use App\Livewire\Components\Modals\Account\ChangeAvatar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ChangeAvatarTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(ChangeAvatar::class)
            ->assertStatus(200);
    }
}
