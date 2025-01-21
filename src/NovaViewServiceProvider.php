<?php

namespace Nauticsoft\NovaView;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Nauticsoft\NovaView\Http\Middleware\Authorize;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Blade;

class NovaViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        $tools = NovaView::getTools();

        foreach ($tools as $tool => $config) {
            $route = 'nova-vendor/nova-view/'.$tool.'/';

            Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-view/'.$tool)
                ->get('/', fn () => inertia('NovaView', [
                    'title' => $config['name'] ?? $tool,
                    'route' => $route,
                ]));

            Route::middleware(['nova', Authorize::class])
                ->prefix($route)
                ->get('/', function() use ($tool) {
                    return Blade::render("@include('".NovaView::getView($tool)."')");
                });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
