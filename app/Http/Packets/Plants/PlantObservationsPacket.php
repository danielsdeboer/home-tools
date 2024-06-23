<?php

namespace App\Http\Packets\Plants;

use App\Http\Packets\CollectionPacket;
use App\Http\Packets\ModelPacket;
use App\Http\Packets\Observations\ObservationPacket;
use App\Models\Plant;

/** @extends ModelPacket<Plant> */
class PlantObservationsPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'observations' => new CollectionPacket(
				$this->model->observations,
				ObservationPacket::class,
			),
		];
	}
}
