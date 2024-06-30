<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

class HasScope implements ScopeInterface
{
	private MultiScope|null $scopes;

	public function __construct(
		protected readonly string $relation,
		ScopeInterface ...$scopes,
	)
	{
		$this->scopes = count($scopes)
			? new MultiScope(...$scopes)
			: null;
	}

	public function apply(Builder $builder): Builder
	{
		if ($this->scopes) {
			return $builder->whereHas(
				$this->relation,
				fn (Builder $query) => $this->scopes->apply($query),
			);
		}

		return $builder->has($this->relation);
	}
}
