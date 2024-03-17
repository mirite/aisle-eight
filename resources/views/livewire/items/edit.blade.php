<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\ItemFields;
use App\Models\Item;

new class extends Component {
    public Item $item;
    use ItemFields;
    public function mount(): void
    {
        $this->name = $this->item->name;
    }

    public function update(): void
    {
        $this->authorize('update', $this->item);

        $validated = $this->validate();

        $this->item->update($validated);

        $this->dispatch('item-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('item-edit-canceled');
    }
};
?>
<form wire:submit="update">
    @include('livewire.items.itemFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Update') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
