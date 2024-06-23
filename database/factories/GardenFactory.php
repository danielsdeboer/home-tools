<?php

namespace Database\Factories;

use App\Models\Garden;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Garden>
 */
class GardenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(rand(1, 4)),
			'location' => $this->faker->sentence(rand(1, 4)),
        ];
    }
}
