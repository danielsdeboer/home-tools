<?php

namespace App\Models\Scopes\Where;

use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class WhereLikeScope implements ScopeInterface
{
	public function __construct(
		protected readonly string $column,
		protected readonly string|int|float $value,
	) {
	}

	public function apply(Builder $builder): Builder
	{
		return $builder->where($this->column, 'like', $this->value);
	}
}
