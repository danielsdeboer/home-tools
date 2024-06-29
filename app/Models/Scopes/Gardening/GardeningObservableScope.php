<?php

namespace App\Models\Scopes\Gardening;

use App\Models\Garden;
use App\Models\Plant;
use App\Models\Plot;
use App\Models\Scopes\Where\WhereInScope;

class GardeningObservableScope extends WhereInScope
{
	public function __construct()
	{
		parent::__construct('observable_type', [
			(new Plant())->getMorphClass(),
			(new Garden())->getMorphClass(),
			(new Plot())->getMorphClass(),
		]);
	}
}
