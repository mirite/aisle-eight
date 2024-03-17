<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\AisleItem;
use App\Models\Aisle;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use App\Models\AisleItemFields;

new class extends Component {
    use AisleItemFields;

    public Collection $aisles;
    public Collection $items;
    public AisleItem $aisleItem;

    public function mount(): void
    {
        $this->aisles = Aisle::all();
        $this->items = Item::all();

        $this->price = $this->aisleItem->price;
        $this->description = $this->aisleItem->description;
        $this->aisle_id = $this->aisleItem->aisle_id;
        $this->item_id = $this->aisleItem->item_id;
        $this->position = $this->aisleItem->position;
    }

    public function update(): void
    {
        $this->authorize('update', $this->aisleItem);

        $validated = $this->validate();

        $this->aisleItem->update($validated);

        $this->dispatch('aisle-item-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('aisle-item-edit-canceled');
    }
};
?>
<form wire:submit="update">
    @include('livewire.aisleitem.aisleItemFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Update') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
