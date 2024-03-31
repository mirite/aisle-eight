<?php

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $stores;
    public ?Store $editing = null;

    public function mount(): void
    {
        $this->getStores();
    }

    #[On('store-created')]
    public function getStores(): void
    {
        $this->stores = Store::with('user')->get();
    }

    #[On('store-edit')]
    public function edit(Store $store): void
    {
        $this->editing = $store;
        $this->getStores();
    }

    #[On('store-edit-canceled')]
    #[On('store-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getStores();
    }

    public function delete(Store $store): void
    {
        $this->authorize('delete', $store);
        $item->delete();
        $this->getStores();
    }
}; ?>

<x-list-wrapper>
    @foreach ($stores as $store)
        @component('livewire/listitem')
            :wire:key="$store->id"
            >
            <x-slot name="title">
                @if ($store->is($editing))
                    <livewire:store.edit :store="$store" :key="$store->id" />
                @else
                    <x-list-title>{{ $store->name }}</x-list-title>
                @endif
            </x-slot>
            <x-slot name="content">
                @if ($store->aisles->count() > 0)
                    <x-stack-mobile><span class="font-semibold">Aisles:</span>
                        <ol class="m-0">
                            @foreach ($store->aisles as $aisle)
                                <li>{{ $aisle->description }}</li>
                            @endforeach
                        </ol>
                    </x-stack-mobile>
                @else
                    No Aisles Created
                @endif
            </x-slot>
            <x-slot name="tools">
                <x-dropdown-link wire:click="edit({{ $store->id }})">
                    {{ __('Edit') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="delete({{ $store->id }})" wire:confirm="Are you sure to delete this store?">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </x-slot>
        @endcomponent
    @endforeach
</x-list-wrapper>
