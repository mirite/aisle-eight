<?php

use Livewire\Volt\Component;

new class extends Component {
    public \Illuminate\Database\Eloquent\Collection $stores;
    public function mount():void {
$this->getStores();    }

    #[\Livewire\Attributes\On('store-created')]
    public function getStores():void {
        $this->stores = \App\Models\Store::with('user')->get();
    }
    //
}; ?>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
    @foreach ($stores as $store)
        <div class="p-6 flex flex-col gap-2" wire:key="{{ $store->id }}">
            <div class="flex-1">
                <p class="mt-4 text-lg text-gray-900">{{ $store->name }}</p>
            </div>
            <div>
                Aisles: {{ $store->aisles->count() }}
                <ol>
                    @foreach ($store->aisles as $aisle)
                        <li>{{ $aisle->description }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endforeach
</div>
