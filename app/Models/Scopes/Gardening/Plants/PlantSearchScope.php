<?php

namespace App\Models\Scopes\Gardening\Plants;

use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class PlantSearchScope implements ScopeInterface
{
	public function __construct(protected readonly string $term)
	{
	}

	public function apply(Builder $builder): Builder
	{
		$wrapped = sprintf('%%%s%%', $this->term);

		return $builder->where(fn (Builder $query) => $query
			->where('name', 'like', $wrapped)
			->orWhere('variety', 'like', $wrapped)
			->orWhere('botanical', 'like', $wrapped)
		);
	}
}
