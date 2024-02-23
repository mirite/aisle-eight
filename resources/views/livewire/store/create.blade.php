<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function submit(): void {
        $validated = $this->validate();
        auth()->user()->stores()->create($validated);
        $this->name = '';
        $this->dispatch('store-created');
    }
}; ?>

<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label for="name">{{_('Name')}}</label>
            <input type="text" wire:model="name" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="name" aria-describedby="nameHelp" placeholder="Sort of like a story">
        </div>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    </form>
</div>
