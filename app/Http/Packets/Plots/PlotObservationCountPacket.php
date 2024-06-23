<?php

namespace App\Http\Packets\Plots;

use App\Http\Packets\KeyablePacketInterface;
use App\Http\Packets\KeyablePacketTrait;
use App\Http\Packets\ModelPacket;
use App\Models\Plot;

/** @extends ModelPacket<Plot> */
class PlotObservationCountPacket extends ModelPacket implements KeyablePacketInterface
{
	use KeyablePacketTrait;

	public function defaultKey(): string
	{
		return 'observations_count';
	}

	public function keyableData(): int
	{
		return $this->model->observations()->count();
	}

	public function jsonSerialize(): array
	{
		return $this->getData();
	}
}
