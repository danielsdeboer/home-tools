<?php

namespace App\Http\Packets\Gardening\Plants;

use App\Http\Packets\ModelPacket;
use App\Models\Plant;

/** @extends ModelPacket<Plant> */
class PlantStubPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name'];
	}
}
