@props(['active'])

@php
    $classes = $active ?? false ? 'underline decoration-indigo-400' : 'no-underline';
@endphp

<x-link {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</x-link>
