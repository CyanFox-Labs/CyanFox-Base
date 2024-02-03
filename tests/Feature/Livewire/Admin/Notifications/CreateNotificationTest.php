<?php

namespace Tests\Feature\Livewire\Admin\Notifications;

use App\Livewire\Admin\Notifications\CreateNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateNotificationTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateNotification::class)
            ->assertStatus(200);
    }
}
