<?php

use App\Http\Controllers\Shopping\ShoppingItemController;
use App\Http\Controllers\ShoppingController;

$shopping = function () {
	Route::get('/', [ShoppingController::class, 'index'])->name('index');

	Route::resources([
		'items' => ShoppingItemController::class,
	]);
};

Route::prefix('shopping')
	->name('shopping.')
	->scopeBindings()
	->group($shopping);
