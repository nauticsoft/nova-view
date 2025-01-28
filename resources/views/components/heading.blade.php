@props(['level' => 1])
@php
    $level = $level > 4 ? 4 : $level;

    $classes = match ($level) {
        1 => 'font-normal text-xl md:text-xl',
        2 => 'font-normal md:text-xl',
        3 => 'uppercase tracking-wide font-bold text-xs',
        4 => 'font-normal md:text-2xl',
    };
@endphp
<h{{ $level }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</h{{ $level }}>
