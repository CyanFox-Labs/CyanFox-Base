<?php

namespace Tests\Feature\Views\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_register(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }
}
