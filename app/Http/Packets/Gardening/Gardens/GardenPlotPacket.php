<?php

namespace App\Http\Packets\Gardening\Gardens;

use App\Models\Plot;
use JsonSerializable;

class GardenPlotPacket implements JsonSerializable
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
		];
	}
}
