<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

new class extends Component {
    public \App\Models\Store $store;

    #[Validate('required|string|max:255')]
    public string $name = '';

    public function mount(): void
    {
        $this->name = $this->store->name;
    }

    public function update(): void
    {
        $this->authorize('update', $this->store);

        $validated = $this->validate();

        $this->store->update($validated);

        $this->dispatch('store-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('store-edit-canceled');
    }
};
?>
<form wire:submit="update">
    <input type="text" wire:model="name"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">

    <x-input-error :messages="$errors->get('name')" class="mt-2" />
    <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
