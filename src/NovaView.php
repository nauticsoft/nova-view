<?php

namespace Nauticsoft\NovaView;

use UnexpectedValueException;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Tool;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use NovaView\NovaView\Http\Middleware\Authorize;

class NovaView extends Tool
{
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

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        //
    }

    public static function getTools(): array
    {
        return config('nova.views', []);
    }

    public static function getView(string $tool): string
    {
        if (! $tool = self::findTool($tool)) {
            throw new UnexpectedValueException("Nova view [{$tool}] not defined.");
        }

        return $tool['view'];
    }

    public static function menuFor(string $tool)
    {
        if (! $config = self::findTool($tool)) {
            throw new UnexpectedValueException("Nova view [{$tool}] not defined.");
        }

        return MenuSection::make($config['menu'] ?? Str::apa($tool))
            ->path('/nova-view/'.$tool)
            ->icon($config['icon'] ?? 'server');
    }

    private static function findTool(string $tool): ?array
    {
        return self::getTools()[$tool] ?? null;
    }

}
