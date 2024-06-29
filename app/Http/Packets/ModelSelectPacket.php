<?php

namespace App\Http\Packets;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

/** @template T of Model */
class ModelSelectPacket implements JsonSerializable
{
	/** @param string|list<string> $titleColumns */
	public function __construct(
		protected readonly Model $model,
		protected readonly array $titleColumns = ['name'],
		protected readonly string $valueColumn = 'uuid',
	) {
	}

	public function jsonSerialize(): array
	{
		return $this->getCollection()
			->map($this->mapper(...))
			->values()
			->toArray();
	}

	protected function mapper(Model $model): array
	{
		return [
			'value' => $model->{$this->valueColumn},
			'title' => $this->getTitle($model),
		];
	}

	protected function getTitle(Model $model): string
	{
		return implode(
			' - ',
			array_map(
				fn (string $column) => $model->{$column},
				$this->titleColumns,
			),
		);
	}

	protected function getCollection(): Collection
	{
		$query = $this->model->newQuery()->select($this->getSelects());

		foreach ($this->titleColumns as $column) {
			$query->orderBy($column);
		}

		return $query->get();
	}

	protected function getSelects(): array
	{
		return [$this->valueColumn, ...$this->titleColumns];
	}
}
