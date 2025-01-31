<?php

namespace Nauticsoft\NovaView;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Nauticsoft\NovaView\Http\Middleware\Authorize;
use UnexpectedValueException;

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

        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'nova-view');
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

        $registeredSlugs = [];

        foreach (NovaView::getViews() as $view) {
            $slug = $view->getSlug();

            if (in_array($slug, $registeredSlugs)) {
                throw new UnexpectedValueException("There is already a Nova View registered with the slug [{$slug}]. Duplicate found in [".get_class($view).']');
            }

            $registeredSlugs[] = $slug;

            $route = 'nova-vendor/nova-view/'.$slug.'/';

            Nova::router(['nova', Authenticate::class, Authorize::class], 'nova-view/'.$slug)
                ->get('/', function (Request $request) use ($view, $route) {
                    if ($request->query() !== []) {
                        $route .= '?'.http_build_query($request->query());
                    }

                    return inertia('NovaView', [
                        'title' => $view->getTitle(),
                        'route' => $route,
                    ]);
                });

            Route::middleware(['nova', Authenticate::class, Authorize::class])
                ->prefix($route)
                ->get('/', fn () => Blade::render("@include('".$view->getView()."')"));
        }
    }
}
