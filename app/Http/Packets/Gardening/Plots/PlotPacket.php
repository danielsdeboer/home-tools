<?php

namespace App\Http\Packets\Gardening\Plots;

use App\Http\Packets\ModelPacket;
use App\Models\Plot;

/** @extends ModelPacket<Plot> */
class PlotPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return [
			'uuid',
			'name',
			'description',
		];
	}

	public function data(): array
	{
		return [
			'planted_at' => $this->model->planted_at,
			'germinated_at' => $this->model->germinated_at,
			'harvested_at' => $this->model->harvested_at,
		];
	}
}
