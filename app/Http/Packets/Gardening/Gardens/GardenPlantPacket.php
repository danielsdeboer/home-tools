<?php

namespace App\Http\Packets\Gardening\Gardens;

use App\Models\Plant;
use JsonSerializable;

class GardenPlantPacket implements JsonSerializable
{
	public function __construct(private readonly Plant $plant)
	{
	}

	public function jsonSerialize(): array
	{
		return [
			'uuid' => $this->plant->getKey(),
			'name' => sprintf(
				'%s - %s',
				$this->plant->name,
				$this->plant->variety,
			),
		];
	}
}
