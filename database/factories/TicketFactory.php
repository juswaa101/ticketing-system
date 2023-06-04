<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_user_id' => rand(1, 10),
            'ticket_status_id' => rand(1, 3),
            'ticket_category_id' => rand(1, 10),
            'ticket_department_id' => rand(1, 10),
            'title' => $this->faker->text(20),
            'message' => $this->faker->text(50),
            'priority' => rand(0, 2)
        ];
    }
}
