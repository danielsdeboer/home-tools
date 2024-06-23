<?php

namespace App\Http\Controllers\Gardening;

use App\Models\Garden;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GardenPlotController
{
	public function store(Request $request, Garden $garden): RedirectResponse
	{
		$validated = $request->validate([
			'plant_uuid' => ['required', 'exists:plants,uuid'],
			'name' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
			'planted_at' => ['required', 'date'],
			'germinated_at' => ['present', 'nullable', 'date'],
			'harvested_at' => ['present', 'nullable', 'date'],
		]);

		$garden->plots()->create($validated);

		return redirect()->back();
	}
}
