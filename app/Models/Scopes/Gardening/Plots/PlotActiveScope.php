<?php

namespace App\Models\Scopes\Gardening\Plots;

use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class PlotActiveScope implements ScopeInterface
{
	public function apply(Builder $builder): Builder
	{
		return $builder->whereNull('harvested_at');
	}
}
