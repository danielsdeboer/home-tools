<?php

namespace App\Http\Packets\Gardening\Plants;

use App\Http\Packets\ModelPacket;
use App\Models\Plant;

/** @extends ModelPacket<Plant> */
class PlantPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name', 'variety', 'botanical'];
	}
}
