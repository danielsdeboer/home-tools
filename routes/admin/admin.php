<?php

use App\Http\Controllers\HomeController;
use App\Providers\RouteServiceProvider;

Route::get('', [HomeController::class, 'index'])
	->name('index');
