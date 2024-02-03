<?php

namespace Tests\Feature\Livewire\Components\Modals\Admin\Notifications;

use App\Livewire\Components\Modals\Admin\Notifications\DeleteNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteNotificationTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DeleteNotification::class)
            ->assertStatus(200);
    }
}
