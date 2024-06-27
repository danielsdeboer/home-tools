<?php

namespace App\Providers;

use App\Models\Garden;
use App\Models\Plant;
use App\Models\Plot;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}

	public function boot(): void
	{
		Relation::enforceMorphMap([
			'garden' => Garden::class,
			'plot' => Plot::class,
			'plant' => Plant::class,
			'user' => User::class,
		]);

		Model::preventLazyLoading(!$this->app->isProduction());
	}
}
