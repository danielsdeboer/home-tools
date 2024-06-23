<?php

namespace App\Http\Controllers\Gardening;

use App\Http\Requests\Observations\ObservationRequest;
use App\Models\Observation;
use App\Models\Plot;
use Illuminate\Http\RedirectResponse;

class PlotObservationController
{
	public function store(ObservationRequest $request, Plot $plot): RedirectResponse
	{
		$plot->observations()->create($request->getValidatedForStore());

		return redirect()->back();
	}

	public function update(
		ObservationRequest $request,
		Plot $plot,
		Observation $observation,
	): RedirectResponse {
		$observation->update($request->getValidatedForUpdate($observation));

		return redirect()->back();
	}
}
