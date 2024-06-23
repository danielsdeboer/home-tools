<?php

namespace App\Models\Observations;

use App\Models\Observation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasObservationsInterface
{
	/** @return Collection<Observation> */
	public function getObservations(): Collection;
	public function observations(): MorphMany;
}
