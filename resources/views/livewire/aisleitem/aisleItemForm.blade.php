<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\AisleItem;
use App\Models\Aisle;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {
    public Collection $aisles;
    public Collection $items;
    public ?AisleItem $editing = null;

    #[Validate('string|max:255')]
    public string $price;

    #[Validate('string|max:255')]
    public string $description;

    #[Validate('integer|min:0|max:100')]
    public int $position;

    #[Validate('required|exists:aisles,id')]
    public string $aisle_id;

    #[Validate('required|exists:items,id')]
    public string $item_id;

    public function mount(?string $editingID = null): void
    {
        $this->aisles = Aisle::all();
        $this->items = Item::all();

        if (isset($editingID)) {
            $this->editing = AisleItem::findOrFail($editingID);
            $this->price = $this->editing->price;
            $this->description = $this->editing->description;
            $this->aisle_id = $this->editing->aisle_id;
            $this->item_id = $this->editing->item_id;
            $this->position = $this->editing->position;
        } else {
            $this->price = '';
            $this->description = '';
            $this->aisle_id = '';
            $this->item_id = '';
            $this->position = 0;
        }
    }

    public function submit(): void
    {
        $validated = $this->validate();
        if ($this->editing) {
            $this->authorize('update', $this->editing);
            $this->editing->update($validated);
            $this->dispatch('aisle-item-updated');
        } else {
            auth()->user()->aisleItems()->create($validated);
            $this->dispatch('aisle-item-created');
        }
        $this->price = '';
        $this->description = '';
        $this->aisle_id = '';
        $this->item_id = '';
        $this->position = 0;
    }
};
?>
<form wire:submit="submit">
    @include('components.form-select', [
        'label' => __('Item'),
        'id' => 'item_id',
        'model' => 'item_id',
        'children' => $items,
        'placeholder' => __('Select an item'),
        'childLabelField' => 'name',
        'error' => $errors->get('item_id'),
    ])
    @include('components.form-select', [
        'label' => __('Aisle'),
        'id' => 'aisle_id',
        'model' => 'aisle_id',
        'children' => $aisles,
        'placeholder' => __('Select an aisle'),
        'childLabelField' => fn($aisle) => $aisle->store->name . '->' . $aisle->description,
        'error' => $errors->get('aisle_id'),
    ])
    @include('components.form-input', [
        'label' => __('Price'),
        'id' => 'price',
        'model' => 'price',
        'placeholder' => __('Optional'),
        'error' => $errors->get('price'),
    ])
    @include('components.form-input', [
        'label' => __('Units'),
        'id' => 'description',
        'model' => 'description',
        'placeholder' => __('Like "Per Pound" or "Per Each""'),
        'error' => $errors->get('description'),
    ])
    @include('components.form-input', [
        'label' => __('Position'),
        'id' => 'position',
        'model' => 'position',
        'type' => 'number',
        'placeholder' => __('Where it lives in the aisle'),
        'error' => $errors->get('position'),
    ])

    <div class="flex justify-end">
        <x-primary-button>{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
</form>
