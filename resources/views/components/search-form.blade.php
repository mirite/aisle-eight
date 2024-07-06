<div {{ $attributes->class(['flex gap-2 flex-col']) }}>
    <x-input-label for="search">{{ __('Search') }}</x-input-label>
    <x-input-text type="text" id="search" wire:model="search" wire:change="filterItems" />
    <x-primary-button>Search</x-primary-button>
</div>
