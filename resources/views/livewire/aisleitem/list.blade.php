<?php

use function Livewire\Volt\{state};
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;
new class extends Component {
    public Collection $aisleItems;

    public function mount(): void
    {
        $this->aisleItems = $this->getItems();
    }

    #[On('aisleItem.created')]
    public function getItems(): Collection
    {
        return auth()->user()->aisleItems()->get();
    }
}; ?>

<div>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
        @foreach ($aisleItems as $aisleItem)
            <div class="p-6 flex space-x-2" wire:key="{{ $aisleItem->id }}">
                @include('aisleItem.single', ['aisleItem' => $aisleItem])
            </div>
        @endforeach
    </div>
</div>
