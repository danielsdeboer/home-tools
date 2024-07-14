<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/admin';

    public function boot(): void
    {
        $this->routes(function () {
			Route::middleware(['web', 'auth'])
				->prefix('admin')
				->name('admin.')
				->group(base_path('routes/admin/admin.php'))
				->group(base_path('routes/admin/bookmarks.php'))
				->group(base_path('routes/admin/farm.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/web.php'))
				->group(base_path('routes/shopping.php'));

			Route::middleware(['web'])
				->group(base_path('routes/auth.php'));
        });
    }
}
