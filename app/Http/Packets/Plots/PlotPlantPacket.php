<?php

namespace App\Http\Packets\Plots;

use App\Http\Packets\ModelPacket;
use App\Models\Plot;

/** @extends ModelPacket<Plot> */
class PlotPlantPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'plant' => [
				'uuid' => $this->model->plant->getKey(),
				'name' => $this->model->plant->name,
			],
		];
	}
}
