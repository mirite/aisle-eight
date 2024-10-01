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
    <a class="bg-green-700 text-white px-4 py-2 rounded-2xl min-w-fit no-underline hover:bg-green-800 transition duration-150 ease-in-out"
        href="{{ route('grocery-list/usenewestlist') }}" wire:navigate>
        Shop Now</a>
    @foreach ($navItems as $slug => $name)
        <x-nav-link wire:key="{{ $slug }}" :href="route($slug)" :active="request()->routeIs($slug)" wire:navigate>
            {{ $name }}
        </x-nav-link>
    @endforeach
</menu>
