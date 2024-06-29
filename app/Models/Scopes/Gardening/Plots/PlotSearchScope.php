<?php

namespace App\Models\Scopes\Gardening\Plots;

use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class PlotSearchScope implements ScopeInterface
{
	public function __construct(protected readonly string $term)
	{
	}

	public function apply(Builder $builder): Builder
	{
		$wrapped = sprintf('%%%s%%', $this->term);

		return $builder->where(fn (Builder $query) => $query->where(
			'name',
			'like',
			$wrapped,
		));
	}
}
