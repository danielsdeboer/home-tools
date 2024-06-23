<?php

namespace App\Http\Packets;

use JsonSerializable;

/** @template T */
class ComboPacket implements JsonSerializable
{
	/** @var list<class-string<JsonSerializable>> */
	private array $packets;

	/**
	 * @param T $basis
	 * @param list<class-string<JsonSerializable>> $packets
	 */
	public function __construct(
		private readonly mixed $basis,
		string ...$packets,
	)
	{
		$this->packets = $packets;
	}

	public function jsonSerialize(): array
	{
		$data = [];

		foreach ($this->packets as $packet) {
			$packet = new $packet($this->basis);

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
