<?php

namespace App\Http\Packets;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

/**
 * @template T of Model
 */
abstract class ModelPacket implements JsonSerializable
{
	/** @param T $model */
	public function __construct(protected readonly Model $model)
	{
	}

	/** @return list<string> */
	public function pluckedData(): array
	{
		return [];
	}

	/** @return array<string, mixed> */
	public function data(): array
	{
		return [];
	}

	public function jsonSerialize(): array
	{
		return [
			...$this->pluck($this->pluckedData()),
			...$this->data(),
		];
	}

	/** @param list<string> $keys */
	protected function pluck(array $keys): array
	{
		$data = [];

		foreach ($keys as $key) {
			$data[$key] = $this->model->$key;
		}

		return $data;
	}
}
