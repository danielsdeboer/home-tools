<?php

namespace App\Http\Packets;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use JsonSerializable;

class PaginationPacket implements JsonSerializable
{
	public function __construct(
		protected readonly LengthAwarePaginator $paginator,
		protected readonly string|Closure $packet,
	)
	{
	}

	public function jsonSerialize(): array
	{
		return [
			'page_current' => $this->paginator->currentPage(),
			'page_last' => $this->paginator->lastPage(),
			'page_size' => $this->paginator->perPage(),
			'items_from' => $this->paginator->firstItem(),
			'items_to' => $this->paginator->lastItem(),
			'items_total' => $this->paginator->total(),
			'data' => new CollectionPacket(
				new Collection($this->paginator->items()),
				$this->packet,
			),
		];
	}
}
