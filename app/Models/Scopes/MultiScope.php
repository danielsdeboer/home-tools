<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

class MultiScope implements ScopeInterface
{
	/** @var list<ScopeInterface> */
	protected array $scopes;

	/** @param list<ScopeInterface> $scopes */
	public function __construct(ScopeInterface ...$scopes)
	{
		$this->scopes = $scopes;
	}

	public function apply(Builder $builder): Builder
	{
		return array_reduce(
			$this->scopes,
			fn (Builder $builder, ScopeInterface $scope) => $scope->apply(
				$builder,
			),
			$builder,
		);
	}
}
