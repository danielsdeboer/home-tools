<?php

namespace App\Http\Packets\Gardening\Projects;

use App\Http\Packets\ModelPacket;
use App\Models\Plant;

/** @extends ModelPacket<Plant> */
class ProjectPlantPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'notes' => $this->model->pivot->notes,
		];
	}
}
