<?php

use App\Models\GroceryList;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $lists;
    public ?GroceryList $editing = null;

    public function mount(): void {
        $this->lists = $this->getLists();
    }

    #[On( 'grocery-list-created' )]
    public function getLists(): Collection {
        return auth()->user()->groceryLists()->get();
    }

    #[On( 'grocery-list-edit' )]
    public function edit( GroceryList $list ): void {
        $this->editing = $list;
        $this->getLists();
    }

    #[On( 'grocery-list-edit-canceled' )]
    #[On( 'grocery-list-updated' )]
    public function disableEditing(): void {
        $this->editing = null;

        $this->getLists();
    }

    public function delete( GroceryList $list ): void {
        $this->authorize( 'delete', $list );
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
                    <livewire:grocerylist.edit :groceryList="$list" :key="$list->id"/>
                @else
                    <x-list-title>
                        {{ $list->title }}
                    </x-list-title>
                @endif
            </x-slot>
            <x-slot name="content">
                <div class="flex-1">
                    <div>
                        <small class="text-sm text-gray-600 dark:text-gray-200">Added:
                            {{ $list->created_at->format('j M Y, g:i a') }}</small>
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
