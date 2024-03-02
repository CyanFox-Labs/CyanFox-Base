<?php

namespace Database\Factories;

use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'user_id' => 1,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'payload' => '',
            'last_activity' => time(),
        ];
    }
}
