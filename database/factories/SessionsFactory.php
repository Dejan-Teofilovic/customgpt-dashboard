<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sessions>
 */
class SessionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => '',
            'user_id' => '',
            'ip_address' => '',
            'user_agent' => '',
            'payload' => '',
            'last_activity' => ''
        ];
    }
}
