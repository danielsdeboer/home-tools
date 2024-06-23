<?php

namespace App\Http\Packets;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JsonSerializable;

/** @template T of Model */
class CollectionPacket implements JsonSerializable
{
	/** @param Collection<T> $collection */
	public function __construct(
		protected readonly Collection $collection,
		protected readonly string|Closure $packet,
	) {
	}

	public function jsonSerialize(): mixed
	{
		return $this->collection->map(
			fn ($item) => $this->packet instanceof Closure
				? $this->fromCallback($item)
				: $this->fromPacketFqcn($item)
		);
	}

	/**
	 * Create a new Packet instance when $this->packed is a class string.
	 */
	protected function fromPacketFqcn(mixed $item): JsonSerializable
	{
		return new ($this->packet)($item);
	}

	protected function fromCallback(mixed $item): JsonSerializable
	{
		return ($this->packet)($item);
	}
}
