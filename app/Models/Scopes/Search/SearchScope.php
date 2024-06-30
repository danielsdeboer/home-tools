<?php

namespace App\Models\Scopes\Search;

use App\Models\Scopes\MultiScope;
use App\Models\Scopes\ScopeInterface;
use App\Models\Scopes\Where\WhereLikeScope;
use Illuminate\Database\Eloquent\Builder;

class SearchScope implements ScopeInterface
{
	public function __construct(
		protected readonly string $term,
		protected readonly array $columns,
	) {
	}

	public function apply(Builder $builder): Builder
	{
		return $builder->orWhere(
			fn (Builder $query) => $this->getScopes()->apply($query),
		);
	}

	protected function getScopes(): MultiScope
	{
		$scopes = new MultiScope();

		foreach ($this->columns as $column) {
			$scopes->push(
				new WhereLikeScope($column, $this->getWildcardTerm()),
			);
		}

		return $scopes;
	}

	protected function getWildcardTerm(): string
	{
		return sprintf('%%%s%%', $this->term);
	}
}
