<?php

use App\Http\Controllers\Gardening\ObservationController;
use App\Http\Controllers\Gardening\PlantPhotoController;
use App\Http\Controllers\GardeningController;
use App\Http\Controllers\Gardening\GardenController;
use App\Http\Controllers\Gardening\GardenObservationController;
use App\Http\Controllers\Gardening\GardenPlotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Gardening\PlantController;
use App\Http\Controllers\Gardening\PlantLinkController;
use App\Http\Controllers\Gardening\PlantObservationController;
use App\Http\Controllers\Gardening\PlotController;
use App\Http\Controllers\Gardening\PlotObservationController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

Route::get(RouteServiceProvider::HOME, [HomeController::class, 'index'])
	->name('home.index');

Route::prefix('gardening')->name('gardening.')->group(function () {
	Route::get('/', [GardeningController::class, 'index'])
		->name('index');

	Route::resources([
		'gardens' => GardenController::class,
		'plants' => PlantController::class,
		'plots' => PlotController::class,
	]);

	Route::resource('gardens.plots', GardenPlotController::class)
		->only(['store']);

	Route::resource('gardens.observations', GardenObservationController::class)
		->only(['store', 'update']);

	Route::resource('plants.observations', PlantObservationController::class)
		->only(['store', 'update']);

	Route::resource('plants.photos', PlantPhotoController::class)
		->only(['store', 'destroy']);

	Route::resource('plants.links', PlantLinkController::class)
		->only(['store', 'update']);

	Route::resource('plots.observations', PlotObservationController::class)
		->only(['store', 'update']);

	Route::get('observations', [ObservationController::class, 'index'])
		->name('observations.index');
})->scopeBindings();
