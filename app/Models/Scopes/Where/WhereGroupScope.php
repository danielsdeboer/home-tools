<?php

namespace App\Models\Scopes\Where;

use App\Models\Scopes\MultiScope;
use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class WhereGroupScope implements ScopeInterface
{
	private MultiScope|null $scopes;

	public function __construct(ScopeInterface ...$scopes)
	{
		$this->scopes = new MultiScope(...$scopes);
	}

	public function apply(Builder $builder): Builder
	{
		return $builder->where(
			fn (Builder $query) => $this->scopes->apply($query),
		);
	}
}
