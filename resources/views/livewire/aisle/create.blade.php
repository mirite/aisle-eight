<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:256')]
    public string $description = '';

    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    public function store(): void {
        $validated = $this->validate();
        auth()->user()->stores()->create($validated);
        $this->description = '';
        $this->position = 0;
    }
}; ?>

<div>
    <form wire:submit="store">
        <textarea
            wire:model="description"
            placeholder="{{ __('Like the banana aisle') }}"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>
        <x-input-error :descriptions="$errors->get('description')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    </form>
</div>
