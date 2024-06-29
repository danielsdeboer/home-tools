<?php

namespace Database\Factories;

use App\Models\Enums\ObservationStatus;
use App\Models\Observation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Observation>
 */
class ObservationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraphs(rand(2, 7), asText: true),
			'observed_at' => now()->subDays(rand(0, 365)),
			'status' => $this->faker->randomElement(ObservationStatus::cases()),
			'observable_uuid' => '0',
			'observable_type' => '0',
        ];
    }
}
