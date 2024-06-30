<?php

namespace App\Http\Controllers\Gardening;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectPlantController
{
	public function store(Request $request, Project $project): RedirectResponse
	{
		$validated = $request->validate([
			'plant_uuid' => ['required', 'exists:plants,uuid'],
		]);

		$project->plants()->attach($validated['plant_uuid']);

		return redirect()->back();
	}

	public function new(Request $request, Project $project): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'variety' => ['required', 'string'],
			'botanical' => ['required', 'string'],
		]);

		$project->plants()->create($validated);

		return redirect()->back();
	}
}
