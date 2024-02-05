<?php

namespace Tests\Feature\Livewire\Account;

use App\Livewire\Account\Notifications;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(Notifications::class)
            ->assertStatus(200);
    }
}
