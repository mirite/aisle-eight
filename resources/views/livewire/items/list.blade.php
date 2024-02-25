<?php

use App\Models\Item;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $items;

    public function mount():void {
        $this->items = $this->getItems();
    }

    #[On('item-created')]
    public function getItems(): Collection {
        return auth()->user()->items()->get();
    }
}; ?>

    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($items as $item)
        <div class="p-6 flex space-x-2" wire:key="{{ $item->id }}">
            <div class="flex-1">
                    <div>
                        <small class="text-sm text-gray-600">Added: {{ $item->created_at->format('j M Y, g:i a') }}</small>
                    </div>
                <p class="mt-4 text-lg text-gray-900">{{ $item->name }}</p>
                <div>
                    <span>Aisles:</span>
                    <ul>
                        @foreach ($item->aisleItems()->get() as $aisle)
                            <li wire:key="{{$aisle->id}}">{{ $aisle->store() }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
