<?php

namespace App\Http\Packets\Gardens;

use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Observations\ObservationPacket;
use App\Models\Garden;
use JsonSerializable;

class GardensShowPacket implements JsonSerializable
{
	public function __construct(private readonly Garden $garden)
	{
	}

	public function jsonSerialize(): array
	{
		return [
			'uuid' => $this->garden->getKey(),
			'name' => $this->garden->name,
			'location' => $this->garden->location,
			'description' => $this->garden->description,
			'plots' => new CollectionPacket(
				$this->garden->plots,
				GardenPlotPacket::class
			),
			'observations' => new CollectionPacket(
				$this->garden->observations,
				ObservationPacket::class
			),
		];
	}
}
