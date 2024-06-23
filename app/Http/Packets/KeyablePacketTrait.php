<?php

namespace App\Http\Packets;

use Illuminate\Support\Collection;

/**
 * @implements KeyablePacketInterface
 */
trait KeyablePacketTrait
{
	protected string|null $key = null;
	protected bool $keyed = false;

	public function getKey(): string
	{
		return $this->key ?? $this->defaultKey();
	}

	public function setKey(string|null $key): void
	{
		$this->key = $key;
	}

	public function setKeyed(bool $keyed): void
	{
		$this->keyed = $keyed;
	}

	abstract public function defaultKey(): string;
	abstract public function keyableData(): mixed;

	public function getData(): array|Collection
	{
		if ($this->keyed) {
			return [
				$this->getKey() => $this->keyableData(),
			];
		}

		return $this->keyableData();
	}
}
