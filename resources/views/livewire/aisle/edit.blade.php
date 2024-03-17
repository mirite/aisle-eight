<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    public \App\Models\Aisle $aisle;

    #[Validate('required|string|max:255')]
    public string $description = '';

    public function mount(): void
    {
        $this->description = $this->aisle->description;
    }

    public function update(): void
    {
        $this->authorize('update', $this->aisle);

        $validated = $this->validate();

        $this->aisle->update($validated);

        $this->dispatch('aisle-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('aisle-edit-canceled');
    }
};
?>
<form wire:submit="update">
    <input type="text" wire:model="description"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

    <x-input-error :messages="$errors->get('description')" class="mt-2" />
    <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
