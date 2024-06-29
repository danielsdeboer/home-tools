<?php

namespace App\Http\Packets;

use Illuminate\Database\Eloquent\Model;

/** @template T of Model */
class ModelSelectPacket implements \JsonSerializable
{
	public function __construct(
		protected readonly Model $model,
		protected readonly string $titleColumn = 'name',
		protected readonly string $valueColumn = 'uuid',
	)
	{
	}

	public function jsonSerialize(): array
	{
		$models = $this->model->newQuery()->select([
			$this->valueColumn,
			$this->titleColumn,
		])->get();

		$mapper = fn (Model $model): array => [
			'value' => $model->{$this->valueColumn},
			'title' => $model->{$this->titleColumn},
		];

		return $models->map($mapper)->values()->toArray();
	}
}
