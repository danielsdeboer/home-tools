<?php

namespace App\Http\Controllers\Gardening;

use App\Models\Plant;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectPlantController
{
	public function store(Request $request, Project $project): RedirectResponse
	{
		$validated = $request->validate([
			'plant_uuid' => ['required', 'exists:plants,uuid'],
			'notes' => ['present', 'nullable', 'string'],
		]);

		$project->plants()->attach($validated['plant_uuid'], [
			'notes' => $validated['notes'],
		]);

		return redirect()->back();
	}

	public function update(
		Request $request,
		Project $project,
		Plant $plant,
	): RedirectResponse {
		$validated = $request->validate([
			'notes' => ['present', 'nullable', 'string'],
		]);

		$project->plants()->updateExistingPivot($plant, $validated);

		return redirect()->back();
	}

	public function new(Request $request, Project $project): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'variety' => ['required', 'string'],
			'botanical' => ['required', 'string'],
			'notes' => ['present', 'nullable', 'string'],
		]);

		$notes = ['notes' => $validated['notes']];
		unset($validated['notes']);

		$project->plants()->create($validated, $notes);

		return redirect()->back();
	}
}
