<?php

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    #[On('aisle-form-submitted')]
    public function store($validated): void
    {
        auth()->user()->aisles()->create($validated);
        $this->dispatch('aisle-created');
    }
}; ?>

<livewire:aisle.aisleform />
