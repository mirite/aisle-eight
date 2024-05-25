<?php

use App\Models\Aisle;
use App\Models\AisleItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $aisles;
    public ?Aisle $editing = null;

    public function mount(): void
    {
        $this->getAisles();
    }

    #[On('aisle-created')]
    #[On('aisle-updated')]
    public function getAisles(): void
    {
        $this->aisles = auth()->user()->aisles()->get();
    }

    #[On('aisle-edit')]
    public function edit(Aisle $aisle): void
    {
        $this->editing = $aisle;
        $this->getAisles();
    }

    #[On('aisle-edit-canceled')]
    #[On('aisle-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getAisles();
    }

    public function delete(Aisle $aisle): void
    {
        $this->authorize('delete', $aisle);
        $aisle->delete();
        $this->getAisles();
    }

    public function move(int $aisleId, int $aisleItemId, string $direction): void
    {
        $targetAisle = Aisle::find($aisleId);
        $targetAisleItem = AisleItem::find($aisleItemId);
        $targetAisleItem->move($targetAisle->aisleItems, $direction);
        $this->getAisles();
    }
}; ?>

<x-list-wrapper>
    @foreach ($aisles->sort(fn($a, $b) => $a->store->name <=> $b->store->name)->sortBy('position') as $aisle)
        @component('livewire/listitem')
            :wire:key="$aisle->id"
            >
            <x-slot name="title">
                @if ($aisle->is($editing))
                    <div>
                        <livewire:aisle.aisleForm :editingID="$aisle->id" :key="$aisle->id" />
                        <x-secondary-button type="button" wire:click="disableEditing">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                @else
                    <x-list-title>
                        {{ $aisle->description }}
                    </x-list-title>
                @endif
            </x-slot>
            <x-slot name="content">
                <div>
                    <x-stack-mobile><span>Store:</span><span>{{ $aisle->store->name }}</span></x-stack-mobile>
                    <x-stack-mobile><span>Items: {{ $aisle->aisleItems()->count() }}</span></x-stack-mobile>
                    <ul class="pl-2 flex w-full flex-col gap-6">
                        @foreach ($aisle->aisleItems->sort(fn(AisleItem $a, AisleItem $b) => $a->position <=> $b->position) as $aisleItem)
                            <li>@include('components.aisleItem.single', [
                                'pages.aisleItem' => $aisleItem,
                                'hide' => ['pages.store', 'pages.aisle'],
                            ])
                                @include('livewire.components.movement-controls', [
                                    'args' => [$aisle->id, $aisleItem->id],
                                ])
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-slot>
            <x-slot name="tools">
                <x-dropdown-link wire:click="edit({{ $aisle->id }})">
                    {{ __('Edit') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="delete({{ $aisle->id }})" wire:confirm="Are you sure to delete this aisle?">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </x-slot>
        @endcomponent
    @endforeach
</x-list-wrapper>
