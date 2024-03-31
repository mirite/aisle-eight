@props(['active'])

@php
    $classes = $active ?? false ? 'border-b-2 border-indigo-400' : '';
@endphp

<x-link {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</x-link>
