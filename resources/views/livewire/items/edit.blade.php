<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    public \App\Models\Item $item;
    use \App\Models\ItemFields;
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
