<?php

namespace Database\Seeders;

use App\Models\Garden;
use App\Models\Observation;
use App\Models\Plant;
use App\Models\Plot;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class GardeningObservationsSeeder extends Seeder
{
	/**
	 * @throws Exception
	 */
	public function run(): void
	{
		if (!Garden::count()) {
			throw new Exception('No gardens found.');
		}

		if (!Plant::count()) {
			throw new Exception('No plants found.');
		}

		if (!Plot::count()) {
			throw new Exception('No plots found.');
		}

		$gardens = Garden::all();
		$plants = Plant::all();
		$plots = Plot::all();

		for ($i = 0; $i < 150; $i++) {
			$observables = new Collection([
					$gardens->random(),
					$plants->random(),
					$plots->random(),
				]);

			/** @var Model $observable */
			$observable = $observables->random();

			Observation::factory()
				->for($observable, 'observable')
				->create();
		}
	}
}
