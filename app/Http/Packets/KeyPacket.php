<?php

namespace App\Http\Packets;

use JsonSerializable;

class KeyPacket implements JsonSerializable
{
	public function __construct(
		protected readonly string $key,
		protected readonly JsonSerializable $value,
	) {
	}

	public function jsonSerialize(): array
	{
		return [$this->key => $this->value];
	}
}
