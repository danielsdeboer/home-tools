<?php

namespace Database\Factories;

use App\Models\Garden;
use App\Models\Plot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plot>
 */
class PlotFactory extends Factory
{
	/** @return array<string, mixed> */
	public function definition(): array
	{
		return [
			'garden_uuid' => Garden::factory(),
			'name' => $this->faker->sentence(rand(1, 4)),
			'description' => $this->faker->paragraph(rand(2, 10)),
			'planted_at' => now()->subDays(rand(1, 365)),
			'germinated_at' => rand(0, 1)
				? now()->subDays(rand(1, 365))
				: null,
			'harvested_at' => rand(0, 1)
				? now()->subDays(rand(1, 365))
				: null,
		];
	}
}
