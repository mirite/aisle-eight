<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $message = '';

    public \Illuminate\Database\Eloquent\Collection $aisles;

    public function store():void {
        $validated = $this->validate();
        auth()->user()->items()->create($validated);
        $this->name = '';
        $this->dispatch('item-created');
    }

}; ?>
<div>
<form wire:submit="store">
    <div class="flex items-center gap-2">
    <label for="item">Item</label>
        <input
            id="item"
            wire:model="message"
            type="text"
            placeholder="{{ __('What do you call it?') }}"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >
    </div>
    <div>
Assign to Aisle goes here
    </div>

    <x-input-error :messages="$errors->get('message')" class="mt-2" />
    <x-primary-button class="mt-4">{{ __('Add Item') }}</x-primary-button>
</form>
</div>
