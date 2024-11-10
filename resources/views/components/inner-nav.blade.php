@php
    $navItems = [
        'dashboard' => 'Dashboard',
        'list' => 'Shopping',
        'stores' => 'Stores',
        'aisles' => 'Aisles',
        'items' => 'Items',
        'aisle-items' => 'Aisle Items',
    ];

    $classes = 'gap-4 justify-center items-center flex';
@endphp
<menu {{ $attributes->merge(['class' => $classes]) }}>
<x-shop-now-button/>
    @foreach ($navItems as $slug => $name)
        <x-nav-link wire:key="{{ $slug }}" :href="route($slug)" :active="request()->routeIs($slug)" wire:navigate>
            {{ $name }}
        </x-nav-link>
    @endforeach
</menu>
