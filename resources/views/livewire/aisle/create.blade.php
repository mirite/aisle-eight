<?php

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public function store($validated): void
    {
        auth()->user()->aisles()->create($validated);
        $this->dispatch('aisle-created');
    }
}; ?>

<livewire:aisle.aisleform wire:aisle-form-submitted="store" />
