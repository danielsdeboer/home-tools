<?php

namespace App\Http\Packets\Gardening\Plots;

use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Observations\ObservationPacket;
use App\Models\Plot;
use JsonSerializable;

class PlotShowPacket implements JsonSerializable
{
	public function __construct(private readonly Plot $plot)
	{
	}

	public function jsonSerialize(): array
	{
		return [
			'uuid' => $this->plot->getKey(),
			'name' => $this->plot->name,
			'description' => $this->plot->description,
			'planted_at' => $this->plot->planted_at,
			'germinated_at' => $this->plot->germinated_at,
			'harvested_at' => $this->plot->harvested_at,
			'plant' => [
				'uuid' => $this->plot->plant->getKey(),
				'name' => $this->plot->plant->name,
			],
			'garden' => [
				'uuid' => $this->plot->garden->getKey(),
				'name' => $this->plot->garden->name,
			],
			'observations' => new CollectionPacket(
				$this->plot->observations,
				ObservationPacket::class
			),
		];
	}
}
