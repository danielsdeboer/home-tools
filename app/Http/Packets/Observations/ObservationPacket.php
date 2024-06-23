<?php

namespace App\Http\Packets\Observations;


use App\Http\Packets\ModelPacket;
use App\Models\Observation;

/** @extends ModelPacket<Observation> */
class ObservationPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'content', 'status'];
	}

	public function data(): array
	{
		return [
			'observed_at' => $this->model->observed_at->toDateString(),
		];
	}
}
