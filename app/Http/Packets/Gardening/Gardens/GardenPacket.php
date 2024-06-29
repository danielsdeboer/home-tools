<?php

namespace App\Http\Packets\Gardening\Gardens;

use App\Http\Packets\ModelPacket;
use App\Models\Garden;

/** @extends ModelPacket<Garden> */
class GardenPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name', 'location'];
	}
}
