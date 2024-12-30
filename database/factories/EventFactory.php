<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence($nbWords = 3, $variableNbWords = true),
            'description' => fake()->paragraph($nbrSentances = 3),
            'location' => fake()->company(),
            'address' => fake()->address(),
            'start_date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_date' => fake()->date(),
            'end_time' => fake()->time(),
            'group_id' => fake()->numberBetween(1,10),
            'owner_id' => fake()->numberBetween(1,10)
        ];
    }
}
