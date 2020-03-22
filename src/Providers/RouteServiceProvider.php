<?php

namespace Maravel\Providers;

use App\Http\Middleware\Token;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';
    public const HOME = '/';
    public function boot()
    {

        parent::boot();
    }
    public function map()
    {
        $this->mapEnterRoutes();
        $this->mapDashboardRoutes();

    }

    protected function mapEnterRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(join(\DIRECTORY_SEPARATOR, [__DIR__, '..', 'routes', 'enter.php']));
    }
    protected function mapDashboardRoutes()
    {
        Route::middleware(['web', 'auth'])
            ->namespace($this->namespace . '\Dashboard')
            ->prefix('/dashboard')
            ->as('dashboard.')
            ->group(join(\DIRECTORY_SEPARATOR, [__DIR__, '..', 'routes', 'dashboard.php']));
        if(file_exists(base_path('routes' . DIRECTORY_SEPARATOR . 'dashboard.php')))
        {
            Route::middleware(['web', 'auth', Token::class])
                ->namespace($this->namespace . '\Dashboard')
                ->prefix('/dashboard')
                ->as('dashboard.')
                ->group(base_path('routes' . DIRECTORY_SEPARATOR . 'dashboard.php'));
        }
    }
}
