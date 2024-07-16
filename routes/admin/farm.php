<?php

use App\Http\Controllers\Gardening\GardenController;
use App\Http\Controllers\Gardening\GardenObservationController;
use App\Http\Controllers\Gardening\GardenPlotController;
use App\Http\Controllers\Gardening\ObservationController;
use App\Http\Controllers\Gardening\PlantController;
use App\Http\Controllers\Gardening\PlantLinkController;
use App\Http\Controllers\Gardening\PlantObservationController;
use App\Http\Controllers\Gardening\PlantPhotoController;
use App\Http\Controllers\Gardening\PlotController;
use App\Http\Controllers\Gardening\PlotObservationController;
use App\Http\Controllers\Gardening\PlotPlantController;
use App\Http\Controllers\Gardening\ProjectController;
use App\Http\Controllers\Gardening\ProjectPlantController;
use App\Http\Controllers\GardeningController;

Route::prefix('farm')->name('farm.')->group(function () {
	Route::get('/', [GardeningController::class, 'index'])
		->name('index');

	Route::resources([
		'gardens' => GardenController::class,
		'plants' => PlantController::class,
		'plots' => PlotController::class,
		'projects' => ProjectController::class,
	]);

	// Garden //

	Route::resource('gardens.plots', GardenPlotController::class)
		->only(['store']);

	Route::resource('gardens.observations', GardenObservationController::class)
		->only(['store', 'update']);

	// Plots //

	Route::resource('plots.plants', PlotPlantController::class)
		->only(['store']);

	Route::resource('plots.observations', PlotObservationController::class)
		->only(['store', 'update']);

	// Plants //

	Route::resource('plants.observations', PlantObservationController::class)
		->only(['store', 'update']);

	Route::resource('plants.photos', PlantPhotoController::class)
		->only(['store', 'destroy']);

	Route::resource('plants.links', PlantLinkController::class)
		->only(['store', 'update']);

	// Projects //

	Route::post(
		'projects/{project}/plants/new',
		[ProjectPlantController::class, 'new',]
	)->name('projects.plants.new');

	Route::resource('projects.plants', ProjectPlantController::class)
		->only(['store', 'update']);

	// Observations //

	Route::get('observations', [ObservationController::class, 'index'])
		->name('observations.index');
})->scopeBindings();
