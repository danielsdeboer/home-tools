<?php

namespace App\Models\Scopes;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WhenScope implements ScopeInterface
{
	/** @param Closure(): ScopeInterface $callback */
	public function __construct(
		protected readonly bool $condition,
		protected readonly Closure $callback,
	)
	{
	}

	public function apply(Builder $builder): Builder
	{
		if ($this->condition) {
			return ($this->callback)()->apply($builder);
		}

		return $builder;
	}
}
