<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/', [AuthController::class, 'create'])->name('auth.create');
