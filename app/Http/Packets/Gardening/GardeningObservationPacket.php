<?php

namespace App\Http\Packets\Gardening;

use App\Http\Packets\ModelPacket;
use App\Models\Observation;

/** @extends ModelPacket<Observation> */
class GardeningObservationPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return [
			'uuid',
			'content',
			'status',
			'observable_uuid',
			'observable_type',
		];
	}

	public function data(): array
	{
		return [
			'observed_at' => $this->model->observed_at->toDateString(),
			'observable_name' => $this->model->observable?->name,
		];
	}
}
