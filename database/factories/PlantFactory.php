<?php

namespace Database\Factories;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plant>
 */
class PlantFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(rand(1, 3)),
			'variety' => $this->faker->sentence(rand(1, 3)),
			'botanical' => $this->faker->sentence(rand(1, 3)),
        ];
    }
}
