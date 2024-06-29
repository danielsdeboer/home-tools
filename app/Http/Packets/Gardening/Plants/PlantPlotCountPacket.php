<?php

namespace App\Http\Packets\Gardening\Plants;

use App\Http\Packets\ModelPacket;
use App\Models\Plant;

/** @extends ModelPacket<Plant> */
class PlantPlotCountPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'plots_count' => $this->model->plots_count,
		];
	}
}
