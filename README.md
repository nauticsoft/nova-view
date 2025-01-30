## Nova View
------

**Nova View** is a companion tool for [Laravel Nova](https://nova.laravel.com/). It allows you to add new sections to Nova without the need of creating a new tool.

The new section will display a custom defined Blade view, meaning that you can perform any kind of queries and logic inside that view.

> Note: at the moment the package has only been tested on Nova v4.

## Installation

> **Requires [PHP 8.3+](https://php.net/releases/) and [Laravel Nova 4 or 5](https://nova.laravel.com/)**

You can require Nova View using [Composer](https://getcomposer.org) with the following command:

```bash
composer require nauticsoft/nova-view
```

## Registering the tool

Nova View is a Laravel Nova tool, meaning that you need to register it in order to be able to use it.

On your `NovaServiceProvider`, register the tool like so:
```php
use Nauticsoft\NovaView\NovaView;

/**
 * Get the tools that should be listed in the Nova sidebar.
 *
 * @return array
 */
public function tools()
{
    return [
        NovaView::make(),
    ];
}
```

This will register the tool and add your views to the sidebar.

If you want to build your sidebar manually, you can disable the menu with:
```php
use Nauticsoft\NovaView\NovaView;

/**
 * Get the tools that should be listed in the Nova sidebar.
 *
 * @return array
 */
public function tools()
{
    return [
        NovaView::make()->withoutMenu(),
    ];
}
```

## Creating a Nova View

To create a Nova View you need two files:

- The main class that needs to implement the `Nauticsoft\NovaView\Contracts\NovaView` interface.
- A blade view with your content.

```php
namespace App\Nova\Views;

use Nauticsoft\NovaView\Contracts\NovaView;

class TestNovaView implements NovaView
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
```

```html
// resources/views/nova/test.blade.php

<div class="w-full">
    <h1 class="font-normal text-xl">This is my custom view!</h1>
    <p class="leading-tight mt-3">Welcome to Nova View! For a nice look, make sure to use the classes that Nova is using right now.</p>

    <h1 class="font-normal text-xl mt-6">Remember, this is a blade view!</h1>
    <p class="leading-tight mt-3">This is a blade view, meaning that you can use any blade directive you need:
        <a class="link-default" href="{{ config('app.url') }}"> Go to the home</a>
    </p>
</div>
```

### Register the view

To make Nova View know that you have a view to display, you need to register it in the `config/nova.php` file:

```php
// config/nova.php

'views' => [
    App\Nova\Views\TestNovaView::class,
],
```

## View components

The package comes with a set of components that you can use in your blade views.

```blade
<div class="w-full flex flex-col gap-6">
    <div class="w-full">
        <x-nova-view::heading>This is a custom page</x-nova-view:heading>
        <p class="leading-tight mt-3">Welcome to a custome page made using Nova View components.</p>
    </div>

    <x-nova-view::cards>
        <x-nova-view::card class="p-6" width="1/4">
            <x-nova-view::heading>Some useful information</x-nova-view:heading>
        </x-nova-view::card>
        <x-nova-view::card class="p-6" width="1/4">
            <x-nova-view::heading>Some useful information</x-nova-view:heading>
        </x-nova-view::card>
        <x-nova-view::card class="p-6" width="1/4">
            <x-nova-view::heading>Some useful information</x-nova-view:heading>
        </x-nova-view::card>
        <x-nova-view::card class="p-6" width="1/4">
            <x-nova-view::heading>Some useful information</x-nova-view:heading>
        </x-nova-view::card>
    </x-nova-view::cards>

    <x-nova-view::heading :level="2">List of users</x-nova-view:heading>
    <x-nova-view::table :fields="['ID', 'Name', 'Last Name']" :rows="[[1, 'John', 'Doe'], [2, 'Jane', 'Doe']]" />
</div>
``````

---

Nova View is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.

