<?php

namespace Nauticsoft\NovaView;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Nauticsoft\NovaView\Contracts\NovaView as NovaViewContract;
use UnexpectedValueException;

class NovaView extends Tool
{
    private bool $withoutMenu = false;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-view', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-view', __DIR__.'/../dist/css/tool.css');
    }

    public function withoutMenu(): self
    {
        $this->withoutMenu = true;

        return $this;
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        if ($this->withoutMenu === true) {
            return;
        }

        return $this->getViews()
            ->map(fn ($view) => self::menuFor(get_class($view)));
    }

    /**
     * Get registered views.
     *
     * @return Collection<int, NovaViewContract>
     */
    public static function getViews(): Collection
    {
        return (new Collection(config('nova.views', [])))
            ->map(fn ($view) => new $view)
            ->filter(fn ($view) => $view instanceof NovaViewContract);
    }

    /**
     * Build a main menu for a specific view.
     */
    public static function menuFor(string $viewClass): MenuSection
    {
        $view = self::getViews()->filter(fn ($object) => $viewClass === get_class($object))
            ->first();

        if ($view === null) {
            throw new UnexpectedValueException("Nova view [{$viewClass}] not defined.");
        }

        $icon = method_exists($view, 'getIcon') ? $view->getIcon() : null;

        return MenuSection::make($view->getTitle())
            ->path('/nova-view/'.$view->getSlug())
            ->icon($icon ?: 'server');
    }
}
