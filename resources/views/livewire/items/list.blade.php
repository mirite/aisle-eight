<?php

use App\Models\Item;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $items;
    public ?Item $editing = null;

    public function mount(): void
    {
        $this->getItems();
    }

    #[On('item-created')]
    #[On('item-updated')]
    public function getItems(): void
    {
        $this->items = auth()->user()->items()->get();
    }

    #[On('item-edit')]
    public function edit(Item $item): void
    {
        $this->editing = $item;
        $this->getItems();
    }

    #[On('item-edit-canceled')]
    #[On('item-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getItems();
    }

    public function delete(Item $item): void
    {
        $this->authorize('delete', $item);
        $item->delete();
        $this->getItems();
    }
}; ?>

<x-list-wrapper>
    @foreach ($items as $item)
        @component('livewire/listitem')
            :wire:key="$item->id"
            >
            <x-slot name="title">
                @if ($item->is($editing))
                    <div>
                        <livewire:items.itemForm :itemID="$item->id" :key="$item->id" />
                        <x-secondary-button type="button" wire:click="disableEditing">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                @else
                    <x-list-title>
                        {{ $item->name }}
                    </x-list-title>
                @endif
            </x-slot>
            <x-slot name="content">
                <div class="flex-1">
                    <div>
                        <small class="text-sm text-gray-600 dark:text-gray-200">Added:
                            {{ $item->created_at->format('j M Y, g:i a') }}</small>
                    </div>
                    <div>
                        <span>Aisles:</span>
                        <ul class="p-4 flex flex-col gap-6">
                            @foreach ($item->aisleItems()->get() as $aisleItem)
                                <li wire:key="{{ $aisleItem->id }}">
                                    @include('aisleItem.single', [
                                        'aisleItem' => $aisleItem,
                                        'hide' => ['name'],
                                    ])
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </x-slot>
            <x-slot name="tools">
                <x-dropdown-link wire:click="edit({{ $item->id }})">
                    {{ __('Edit') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="delete({{ $item->id }})" wire:confirm="Are you sure to delete this item?">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </x-slot>
        @endcomponent
    @endforeach
</x-list-wrapper>
