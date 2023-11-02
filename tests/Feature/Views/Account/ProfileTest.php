<?php

namespace Tests\Feature\Views\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_profile(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200);
    }
}
