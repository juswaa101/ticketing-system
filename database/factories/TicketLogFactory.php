<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketLog>
 */
class TicketLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => rand(1, 10),
            'ticket_action_user_id' => rand(1, 10),
            'action_made' => $this->faker->text(30)
        ];
    }
}
