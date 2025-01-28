@props(['width' => 'full', 'height' => ''])
@php
    $classes = match ($width) {
        '1/3' => 'md:col-span-4',
        '1/2' => 'md:col-span-6',
        '1/4' => 'md:col-span-3',
        '2/3' => 'md:col-span-8',
        '3/4' => 'md:col-span-9',
        default => 'md:col-span-12'
    };

    $height = $height === 'fixed' ? 'min-h-40' : '';

    $classes = 'relative overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow h-full '.$height.' '.$classes;
@endphp
<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
