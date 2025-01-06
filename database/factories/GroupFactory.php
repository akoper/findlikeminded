<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
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
            'location_id' => fake()->numberBetween(1,1000),
            'owner_id' => fake()->numberBetween(1,10)
        ];
    }
}
