<?php

namespace Workbench\App\Nova\Views;

use Nauticsoft\NovaView\Contracts\NovaView;

class TestView implements NovaView
{
    public function getTitle(): string
    {
        return 'Test view';
    }

    public function getView(): string
    {
        return 'nova.test';
    }

    public function getSlug(): string
    {
        return 'test';
    }
}
