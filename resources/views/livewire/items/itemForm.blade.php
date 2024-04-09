<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

use App\Models\Item;

new class extends Component {
    public ?Item $editing = null;
    #[Validate('required|string|max:255')]
    public string $name;

    public function mount(?string $itemID = null): void
    {
        if (isset($itemID)) {
            $this->editing = Item::findOrFail($itemID);
            $this->name = $this->editing->name;
        } else {
            $this->name = '';
        }
    }

    public function update(): void
    {
        $validated = $this->validate();
        if ($this->editing) {
            $this->authorize('update', $this->editing);
            $this->editing->update($validated);
            $this->dispatch('item-updated');
        } else {
            auth()->user()->items()->create($validated);
            $this->dispatch('item-created');
        }
        $this->name = '';
    }
};
?>
<form wire:submit="update">
    @include('components.form-input', [
        'label' => 'Name',
        'id' => 'name',
        'model' => 'name',
        'placeholder' => __('What do you call it?'),
        'error' => $errors->get('name'),
    ])

    <div class="flex justify-end">
        <x-primary-button>{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
</form>
