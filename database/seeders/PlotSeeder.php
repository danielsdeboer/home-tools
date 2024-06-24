<?php

namespace Database\Seeders;

use App\Models\Garden;
use App\Models\Plant;
use App\Models\Plot;
use Illuminate\Database\Seeder;

class PlotSeeder extends Seeder
{
	public function run(): void
	{
		$gardens = Garden::all();
		$plants = Plant::all();

		if ($gardens->count() === 0 || $plants->count() === 0) {
			$this->command->warn(
				'No gardens or plants found. Skipping plot seeding.',
			);

			return;
		}
		for ($i = 0; $i < 50; $i++) {
			$plot = Plot::factory()
				->for(
					$gardens->count()
						? $gardens->random()
						: Garden::factory(),
					'garden',
				)
				->create();

			$plot->plants()->sync($plants->random(rand(1, 3))->pluck('uuid'));
		}
	}
}
