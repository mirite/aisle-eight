<?php

use Livewire\Volt\Component;

new class extends Component {
    public \Illuminate\Database\Eloquent\Collection $aisles;
    public function mount():void {
        $this->getAisles();    }

    #[\Livewire\Attributes\On('aisle-created')]
    public function getAisles():void {
        $this->aisles = \App\Models\Aisle::all();
    }
    //
}; ?>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
    @foreach ($aisles as $aisle)
        <div class="p-6 flex flex-col gap-2" wire:key="{{ $aisle->id }}">
            <div class="flex-1">
                <p class="mt-4 text-lg text-gray-900">{{ $aisle->description }}</p>
            </div>
            <div>
                Items: {{ $aisle->items->count() }}
                <ol>
                    @foreach ($aisle->items as $item)
                        <li>{{ $item->message }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endforeach
</div>
