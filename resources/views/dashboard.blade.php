<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul class="flex flex-col gap-2 items-center">
                        <li>
                            <a class="underline" href="{{ route('list') }}">Grocery Lists</a>
                        </li>
                        <li>
                            <a class="underline" href="{{ route('aisle-items') }}">Aisle Items</a>
                        </li>
                        <li>
                            <a class="underline" href="{{ route('items') }}">Items</a>
                        </li>
                        <li>
                            <a class="underline" href="{{ route('aisles') }}">Aisles</a>
                        </li>
                        <li>
                            <a class="underline" href="{{ route('stores') }}">Stores</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
