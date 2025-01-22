<?php

namespace Nauticsoft\NovaView\Contracts;

interface NovaView
{
    /**
     * Get the title of the view.
     */
    public function getTitle(): string;

    /**
     * Get the view.
     */
    public function getView(): string;

    /**
     * Get the slug of the view.
     */
    public function getSlug(): string;
}
