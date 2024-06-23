<?php

namespace App\Http\Packets\Observations;

use App\Http\Packets\CollectionPacket;
use App\Http\Packets\KeyablePacketInterface;
use App\Http\Packets\KeyablePacketTrait;
use App\Models\Observations\HasObservationsInterface;
use Illuminate\Support\Collection;

class ObservationsPacket extends CollectionPacket implements KeyablePacketInterface
{
	use KeyablePacketTrait;

	public function __construct(public readonly HasObservationsInterface $model)
	{
		return parent::__construct(
			$model->getObservations(),
			ObservationPacket::class,
		);
	}

	public function defaultKey(): string
	{
		return 'observations';
	}

	public function keyableData(): Collection
	{
		return parent::jsonSerialize();
	}

	public function jsonSerialize(): array|Collection
	{
		return $this->getData();
	}
}
