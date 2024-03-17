<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('string|max:255')]
    public string $price = '';
    #[Validate('string|max:255')]
    public string $description = '';
    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    #[Validate('required|exists:aisles,id')]
    public string $aisle_id = '';

    #[Validate('required|exists:items,id')]
    public string $item_id = '';

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
    @include('livewire.forminput', [
        'label' => __('Price'),
        'id' => 'price',
        'model' => 'price',
        'placeholder' => __('Optional'),
        'error' => $errors->get('price'),
    ])
    @include('livewire.forminput', [
        'label' => __('Description'),
        'id' => 'description',
        'model' => 'description',
        'placeholder' => __('Like "Per Pound" or "Per Each""'),
        'error' => $errors->get('description'),
    ])
    @include('livewire.forminput', [
        'label' => __('Position'),
        'id' => 'position',
        'model' => 'position',
        'type' => 'number',
        'placeholder' => __('Where it lives in the aisle'),
        'error' => $errors->get('position'),
    ])
    @include('livewire.formselect', [
        'label' => __('Aisle'),
        'id' => 'aisle_id',
        'model' => 'aisle_id',
        'children' => $aisles,
        'placeholder' => __('Select an aisle'),
        'childLabelField' => fn($aisle) => $aisle->store->name . '->' . $aisle->description,
        'error' => $errors->get('aisle_id'),
    ])
    @include('livewire.formselect', [
        'label' => __('Item'),
        'id' => 'item_id',
        'model' => 'item_id',
        'children' => $items,
        'placeholder' => __('Select an item'),
        'childLabelField' => 'name',
        'error' => $errors->get('item_id'),
    ])
    <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
</form>
