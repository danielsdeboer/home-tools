<?php

namespace App\Http\Controllers\Gardening;

use App\Http\Requests\Links\LinkRequest;
use App\Http\Requests\Observations\ObservationRequest;
use App\Models\Link;
use App\Models\Plant;
use Illuminate\Http\RedirectResponse;

class PlantLinkController
{
	public function store(
		LinkRequest $request,
		Plant $plant,
	): RedirectResponse {
		$plant->links()->create($request->validated());

		return redirect()->back();
	}

	public function update(
		ObservationRequest $request,
		Plant $plant,
		Link $link,
	): RedirectResponse {
		$link->update($request->validated());

		return redirect()->back();
	}
}
