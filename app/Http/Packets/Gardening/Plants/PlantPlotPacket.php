<?php

namespace App\Http\Packets\Gardening\Plants;

use App\Http\Packets\ModelPacket;
use App\Models\Plot;

/** @extends ModelPacket<Plot> */
class PlantPlotPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name'];
	}

	public function data(): array
	{
		return [
			'planted_at' => $this->model->planted_at->toDateString(),
			'garden' => [
				'name' => $this->model->garden->name,
			],
		];
	}
}
