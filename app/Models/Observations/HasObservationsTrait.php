<?php

namespace App\Models\Observations;

use App\Models\Observation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 * @mixin HasObservationsInterface
 * @implements HasObservationsInterface
 */
trait HasObservationsTrait
{
	public function getObservations(): Collection
	{
		return $this->observations;
	}

	public function observations(): MorphMany
	{
		return $this->morphMany(
			related: Observation::class,
			name: 'observable',
			id: 'observable_uuid',
		);
	}
}
