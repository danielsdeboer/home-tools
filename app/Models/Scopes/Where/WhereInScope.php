<?php

namespace App\Models\Scopes\Where;

use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class WhereInScope implements ScopeInterface
{
	public function __construct(
		protected readonly string $column,
		protected readonly array $values,
	) {
	}

	public function apply(Builder $builder): Builder
	{
		return $builder->whereIn($this->column, $this->values);
	}
}
