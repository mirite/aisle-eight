<div class="p-6 flex flex-col gap-2 w-full">
    <div class="flex gap-2">
        <div class="grow">
            {{ $title ?? '' }}
        </div>
        <x-dropdown>
            <x-slot name="trigger">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                {{ $tools ?? '' }}
            </x-slot>
        </x-dropdown>
    </div>
    <div>
        {{ $content ?? '' }}
    </div>
</div>
