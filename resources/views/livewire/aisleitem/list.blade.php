<?php

use function Livewire\Volt\{state};
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;
new class extends Component {
    public Collection $aisleItems;

    public function mount():void {
        $this->aisleItems = $this->getItems();
    }

    #[On('aisleItem.created')]
    public function getItems(): Collection {
        return auth()->user()->aisleItems()->get();
    }
}; ?>

<div>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($aisleItems as $aisleItem)
        <div class="p-6 flex space-x-2" wire:key="{{ $aisleItem->id }}">
            <div class="flex-1">
                <div>
                    <small class="text-sm text-gray-600">Added: {{ $aisleItem->created_at->format('j M Y, g:i a') }}</small>
                </div>
                <p class="mt-4 text-lg text-gray-900">{{ $aisleItem->item->name }}</p>
                <div>
                    <span>Aisle:</span>
                    <ul>
                        <li wire:key="{{$aisleItem->id}}">{{ $aisleItem->aisle->store->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
