<?php

use App\Models\GroceryList;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $lists;
    public ?GroceryList $editing = null;

    public function mount(): void
    {
        $this->getLists();
    }

    #[On('grocery-list-created')]
    #[On('grocery-list-updated')]
    public function getLists(): void
    {
        $this->lists = auth()->user()->groceryLists()->get()->sortByDesc('created_at');
    }

    #[On('grocery-list-edit')]
    public function edit(GroceryList $list): void
    {
        $this->editing = $list;
        $this->getLists();
    }

    #[On('grocery-list-edit-canceled')]
    #[On('grocery-list-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getLists();
    }

    public function delete(GroceryList $list): void
    {
        $this->authorize('delete', $list);
        $list->delete();
        $this->getLists();
    }
}; ?>

<x-list-wrapper>
    @foreach ($lists as $list)
        @component('livewire/listitem')
            :wire:key="$list->id"
            >
            <x-slot name="title">
                @if ($list->is($editing))
                    <div>
                        <livewire:grocerylist.groceryListForm :listID="$list->id" :key="$list->id" />
                        <x-secondary-button type="button" wire:click="disableEditing">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                @else
                    <x-list-title>
                        {{ $list->title }}
                    </x-list-title>
                @endif
            </x-slot>
            <x-slot name="content">
                <div class="flex gap-2 grow items-center">
                    @if (
                        $list->listItems->count() > 0 &&
                            $list->listItems->filter(fn($listItem) => $listItem->in_cart)->count() === $list->listItems->count())
                        <span class="font-extrabold text-4xl text-green-500">✓</span>
                    @endif
                    <div class="grow">
                        <div>
                            <small class="text-sm text-gray-600 dark:text-gray-200">Added:
                                {{ $list->created_at->format('j M Y, g:i a') }}</small>
                            <div class="flex flex-col gap-4 py-4 sm:items-center sm:flex-row">
                                <a href="{{ route('grocery-list/uselist', $list) }}"
                                    class="text-blue-500 hover:underline dark:text-blue-300">Shop With This List</a>
                                <a href="{{ route('grocery-list/listbuilder', $list) }}"
                                    class="text-blue-500 hover:underline dark:text-blue-300">Build This List</a>
                            </div>
                            <div>
                                <small class="text-sm text-gray-600 dark:text-gray-200">Items:
                                    {{ $list->listItems()->count() }}</small>
                                @if ($list->listItems()->count() > 0)
                                    <small class="text-sm text-gray-600 dark:text-gray-200">Estimated Total:
                                        ${{ $list->listItems->sum(fn($listItem) => (float) $listItem->aisleItem->price * $listItem->quantity) }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="tools">
                <x-dropdown-link wire:click="edit({{ $list->id }})">
                    {{ __('Edit') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="delete({{ $list->id }})" wire:confirm="Are you sure to delete this list?">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </x-slot>
        @endcomponent
    @endforeach
</x-list-wrapper>
