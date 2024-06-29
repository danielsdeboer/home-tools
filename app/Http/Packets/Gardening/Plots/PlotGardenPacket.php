<?php

namespace App\Http\Packets\Gardening\Plots;

use App\Http\Packets\ModelPacket;
use App\Models\Plot;

/** @extends ModelPacket<Plot> */
class PlotGardenPacket extends ModelPacket
{
	public function data(): array
	{
		return [
			'garden' => [
				'uuid' => $this->model->garden->getKey(),
				'name' => $this->model->garden->name,
			],
		];
	}
}
