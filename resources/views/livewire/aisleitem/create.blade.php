<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    use \App\Models\AisleItemFields;

    public function submit(): void
    {
        $validated = $this->validate();
        auth()->user()->aisleItems()->create($validated);
        $this->price = '';
        $this->description = '';
        $this->aisle_id = '';
        $this->item_id = '';
        $this->position = 0;
        $this->dispatch('aisle-item-created');
    }

    public function mount(): void
    {
        $this->aisles = \App\Models\Aisle::all();
        $this->items = \App\Models\Item::all();
    }

    public \Illuminate\Database\Eloquent\Collection $aisles;
    public \Illuminate\Database\Eloquent\Collection $items;
}; ?>

<form wire:submit.prevent="submit">
    @include('livewire.aisleitem.aisleItemFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
</form>
