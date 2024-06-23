<?php

namespace App\Http\Controllers\Gardening;

use App\Http\Requests\Observations\ObservationRequest;
use App\Models\Garden;
use App\Models\Observation;
use Illuminate\Http\RedirectResponse;

class GardenObservationController
{
	public function store(
		ObservationRequest $request,
		Garden $garden,
	): RedirectResponse {
		$garden->observations()->create($request->getValidatedForStore());

		return redirect()->back();
	}

	public function update(
		ObservationRequest $request,
		Garden $garden,
		Observation $observation,
	): RedirectResponse {
		$observation->update($request->getValidatedForUpdate($observation));

		return redirect()->back();
	}
}
