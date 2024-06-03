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
    public array $units = ['g', 'kg', 'mL', 'L', 'oz', 'lb', 'qt', 'pt', 'fl oz'];

    #[Validate('numeric|max:255')]
    public float $price;

    #[Validate('string|max:255')]
    public string $description;

    #[Validate('integer|min:0|max:100')]
    public int $position;

    #[Validate('integer|min:0|max:10000')]
    public int $size;

    #[Validate('required|exists:aisles,id')]
    public string $aisle_id;

    #[Validate('required|exists:items,id')]
    public string $item_id;

    #[Validate('in_array:units.*')]
    public string $unit = 'g';

    public function mount(?string $editingID = null): void
    {
        $this->aisles = Aisle::all()->sortBy('description');
        $this->items = Item::all()->sortBy('name');

        if (isset($editingID)) {
            $this->editing = AisleItem::findOrFail($editingID);
            $this->price = $this->editing->price;
            $this->description = $this->editing->description;
            $this->aisle_id = $this->editing->aisle_id;
            $this->item_id = $this->editing->item_id;
            $this->position = $this->editing->position;
            $this->size = $this->editing->size;
            $this->unit = $this->editing->unit;
        } else {
            $this->price = 0.0;
            $this->description = '';
            $this->aisle_id = '';
            $this->item_id = '';
            $this->position = 0;
            $this->size = 0;
            $this->unit = 'g';
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
        $this->price = 0.0;
        $this->description = '';
        $this->item_id = '';
        $this->position = $this->position + 1;
        $this->dispatch('formSubmitted');
    }
};
?>
<form wire:submit="submit" data-form="entry">
    <x-form-select label="{{ __('Aisle') }}" id="aisle_id" :model="'aisle_id'" :children="$aisles ?? []"
        placeholder="{{ __('Select an aisle') }}" :childLabelField="fn($aisles) => $aisles->description . ' (' . $aisles->store->name . ')'" :error="$errors->get('aisle_id')" />
    <x-form-select label="{{ __('Item') }}" id="item_id" :model="'item_id'" :children="$items ?? []"
        placeholder="{{ __('Select an item') }}" childLabelField="name" :error="$errors->get('item_id')" />
    <x-form-input label="{{ __('Price') }}" id="price" :model="'price'" type="number" step="0.01"
        :error="$errors->get('price')" />
    <x-form-input label="{{ __('Description') }}" id="description" :model="'description'"
        placeholder="{{ __('Like Salted, Wonder or PC') }}" :error="$errors->get('description')" />
    <x-form-input label="{{ __('Size') }}" id="size" :model="'size'" type="number" step="0.1"
        placeholder="{{ __('ex. 100') }}" :error="$errors->get('size')" />
    <x-form-select label="{{ __('Units') }}" id="unit" :model="'unit'" :children="$units"
        :error="$errors->get('unit')" />
    <x-form-input label="{{ __('Position') }}" id="position" :model="'position'" type="number"
        placeholder="{{ __('Where it lives in the aisle') }}" :error="$errors->get('position')" />
    <div class="flex justify-end">
        <x-primary-button>{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
    @livewire('focusfirstinput')
</form>
