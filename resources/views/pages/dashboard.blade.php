<x-app-layout>
    <div class="py-6 grow flex flex-col justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
            <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul class="flex flex-col gap-4 items-center list-none p-0">
                        <li>
                            <x-link href="{{ route('list') }}">Grocery Lists</x-link>
                        </li>
                        <li>
                            <x-link href="{{ route('aisle-items') }}">Aisle Items</x-link>
                        </li>
                        <li>
                            <x-link href="{{ route('items') }}">Items</x-link>
                        </li>
                        <li>
                            <x-link href="{{ route('aisles') }}">Aisles</x-link>
                        </li>
                        <li>
                            <x-link href="{{ route('stores') }}">Stores</x-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
