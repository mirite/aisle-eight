<?php

use App\Models\AisleFields;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $stores;

    use AisleFields;

    public function store(): void
    {
        $validated = $this->validate();
        auth()->user()->aisles()->create($validated);
        $this->description = '';
        $this->position = 0;
        $this->store_id = 0;
        $this->dispatch('aisle-created');
    }

    public function mount(): void
    {
        $this->stores = Store::with('user')->get();
    }
}; ?>

<form wire:submit="store">
    @include('livewire.aisle.aisleFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Add Aisle') }}</x-primary-button>
</form>
