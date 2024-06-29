<?php

namespace App\Http\Controllers\Gardening;

use App\Models\Plot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlotPlantController
{
	public function store(Request $request, Plot $plot): RedirectResponse
	{
		$validated = $request->validate([
			'plant_uuid' => ['required', 'exists:plants,uuid'],
		]);

		$plot->plants()->attach($validated['plant_uuid']);

		return redirect()->back();
	}
}
