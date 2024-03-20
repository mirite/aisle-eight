<?php

use function Livewire\Volt\{state};

use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AisleItem;

new class extends Component {
    public Collection $aisleItems;
    public ?AisleItem $editing = null;

    public function mount(): void
    {
        $this->aisleItems = $this->getAisleItems();
    }

    #[On('aisle-item-created')]
    public function getAisleItems(): Collection
    {
        return auth()->user()->aisleItems()->get();
    }

    #[On('aisle-item-edit')]
    public function edit(AisleItem $aisleItem): void
    {
        $this->editing = $aisleItem;
        $this->getAisleItems();
    }

    #[On('aisle-item-edit-canceled')]
    #[On('aisle-item-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getAisleItems();
    }

    public function delete(AisleItem $aisleItem): void
    {
        $this->authorize('delete', $aisleItem);
        $aisleItem->delete();
        $this->getAisleItems();
    }
}; ?>

   <x-list-wrapper>
        @foreach ($aisleItems as $aisleItem)
            <div class="p-6 flex space-x-2" wire:key="{{ $aisleItem->id }}">
                @component('livewire/listitem')
                    :wire:key="$aisleItem->id"
                    >
                    <x-slot name="title">
                        @if ($aisleItem->is($editing))
                            <livewire:aisleitem.edit :aisleItem="$aisleItem" :key="$aisleItem->id" />
                        @else
                            <x-list-title>
                            {{ $aisleItem->item->name }}
                            </x-list-title>
                        @endif
                    </x-slot>
                    <x-slot name="content">
                        @include('aisleItem.single', ['aisleItem' => $aisleItem])
                    </x-slot>
                    <x-slot name="tools">
                        <x-dropdown-link wire:click="edit({{ $aisleItem->id }})">
                            {{ __('Edit') }}
                        </x-dropdown-link>
                        <x-dropdown-link wire:click="delete({{ $aisleItem->id }})"
                            wire:confirm="Are you sure to delete this aisle item?">
                            {{ __('Delete') }}
                        </x-dropdown-link>
                    </x-slot>
                @endcomponent
            </div>
        @endforeach
   </x-list-wrapper>

