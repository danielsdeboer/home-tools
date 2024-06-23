<?php

namespace App\Http\Controllers\Gardening;

use App\Http\Requests\Observations\ObservationRequest;
use App\Models\Observation;
use App\Models\Plant;
use Illuminate\Http\RedirectResponse;

class PlantObservationController
{
	public function store(
		ObservationRequest $request,
		Plant $plant,
	): RedirectResponse {
		$plant->observations()->create($request->getValidatedForStore());

		return redirect()->back();
	}

	public function update(
		ObservationRequest $request,
		Plant $plant,
		Observation $observation,
	): RedirectResponse {
		$observation->update($request->getValidatedForUpdate($observation));

		return redirect()->back();
	}
}
