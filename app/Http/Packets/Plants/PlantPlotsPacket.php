<?php

namespace App\Http\Packets\Plants;

use App\Http\Packets\CollectionPacket;
use App\Http\Packets\ModelPacket;
use App\Models\Plant;

/** @extends ModelPacket<Plant> */
class PlantPlotsPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'plots' => new CollectionPacket(
				$this->model->plots,
				PlantPlotPacket::class,
			)
		];
	}
}
