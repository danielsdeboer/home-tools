<?php

namespace App\Http\Packets;

use JsonSerializable;

/** @template T */
class MergePacket implements JsonSerializable
{
	/** @var JsonSerializable|JsonSerializable[] */
	private array $packets;

	public function __construct(JsonSerializable|array ...$packets)
	{
		$this->packets = $packets;
	}

	public function jsonSerialize(): array
	{
		$data = [];

		foreach ($this->packets as $packet) {
			if (is_array($packet)) {
				$data = [...$data, ...$packet];

				continue;
			}

			if ($packet instanceof KeyablePacketInterface) {
				$packet->setKeyed(true);
			}

			$data = [
				...$data,
				...$packet->jsonSerialize(),
			];
		}

		return $data;
	}
}
