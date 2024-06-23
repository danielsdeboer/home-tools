<?php

namespace App\Http\Packets\Gardens;

use App\Http\Packets\ModelPacket;
use App\Models\Garden;

/** @extends ModelPacket<Garden> */
class GardenStubPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name'];
	}
}
