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

		for ($i = 0; $i < 50; $i++) {
			Plot::factory()
				->for(
					$gardens->count()
						? $gardens->random()
						: Garden::factory(),
					'garden',
				)
				->for(
					$plants->count()
						? $plants->random()
						: Plant::factory(),
					'plant',
				)
				->create();
		}
	}
}
