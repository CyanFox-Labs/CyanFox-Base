<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_home(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
    }
}
