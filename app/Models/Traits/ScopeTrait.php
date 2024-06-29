<?php

namespace App\Models\Traits;

use App\Models\Scopes\MultiScope;
use App\Models\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

trait ScopeTrait
{
	public function scopeScope(Builder $builder, ScopeInterface ...$scopes): Builder
	{
		return (new MultiScope(...$scopes))->apply($builder);
	}
}
