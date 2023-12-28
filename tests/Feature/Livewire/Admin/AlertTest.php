<?php

namespace Feature\Livewire\Admin;

use App\Livewire\Admin\Alerts\AlertCreate;
use App\Livewire\Admin\Alerts\AlertEdit;
use App\Livewire\Components\Modals\Admin\Alerts\AlertDelete;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AlertTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function user_can_create_alerts(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(AlertCreate::class)
            ->set('title', 'test')
            ->set('message', 'test')
            ->set('type', 'info')
            ->set('icon', 'icon-bell')
            ->call('createAlert')
            ->assertRedirect(route('admin-alert-list'));
    }

    /** @test */
    public function user_can_edit_alerts(): void
    {
        $this->actingAs(User::factory()->create());

        $alert = Alert::factory()->create();

        Livewire::test(AlertEdit::class, ['alertId' => $alert->id])
            ->set('alert', $alert)
            ->set('alertId', $alert->id)
            ->set('title', 'test')
            ->set('message', 'test')
            ->set('type', 'info')
            ->set('icon', 'icon-bell')
            ->call('updateAlert')
            ->assertRedirect(route('admin-alert-list'));
    }

    /** @test */
    public function user_can_delete_alerts(): void
    {
        $this->actingAs(User::factory()->create());

        $alert = Alert::factory()->create();

        Livewire::test(AlertDelete::class, ['alertId' => $alert->id])
            ->set('alertId', $alert->id)
            ->call('deleteAlert')
            ->assertRedirect(route('admin-alert-list'));
    }
}
