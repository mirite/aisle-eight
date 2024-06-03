<?php

use App\Models\Store;
use App\Models\Aisle;
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
        $store->delete();
        $this->getStores();
    }

    public function move(int $storeId, int $aisleId, string $direction): void
    {
        $targetStore = Store::find($storeId);
        $targetAisle = Aisle::find($aisleId);
        $targetAisle->move($targetStore->aisles, $direction);
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
                    <div>
                        <livewire:store.storeForm :storeID="$store->id" :key="$store->id" />
                        <x-secondary-button type="button" wire:click="disableEditing">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                @else
                    <x-list-title data-testid="store-{{ $store->name }}">{{ $store->name }}</x-list-title>
                @endif
            </x-slot>
            <x-slot name="content">
                @if ($store->aisles->count() > 0)
                    <x-stack-mobile><span class="font-semibold">Aisles:</span>
                        <ol class="m-0">
                            @foreach ($store->aisles->sort(fn(Aisle $a, Aisle $b) => $a->position <=> $b->position) as $aisle)
                                <li>
                                    <span>{{ $aisle->description }}</span>
                                    @include('livewire.components.movement-controls', [
                                        'args' => [$store->id, $aisle->id],
                                    ])
                                </li>
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
