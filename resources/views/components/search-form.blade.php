<div {{ $attributes->class(['flex gap-2 flex-col']) }}>
				<x-input-label for="search">{{ __('Search') }}</x-input-label>
				<x-input-text type="text" id="search" wire:model="search" wire:change="triggerSearch" />
				<x-primary-button wire:click="triggerSearch">Search</x-primary-button>
</div>
