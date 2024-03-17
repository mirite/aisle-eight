<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\AisleItem;
use App\Models\Aisle;
use App\Models\Item;
use App\Models\AisleItemFields;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {
    use AisleItemFields;

    public Collection $aisles;
    public Collection $items;

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
        $this->aisles = Aisle::all();
        $this->items = Item::all();
    }
}; ?>

<form wire:submit.prevent="submit">
    @include('livewire.aisleitem.aisleItemFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
</form>
