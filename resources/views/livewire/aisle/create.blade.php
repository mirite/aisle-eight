<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    public \Illuminate\Database\Eloquent\Collection $stores;

    #[Validate('required|string|max:256')]
    public string $description = '';

    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    #[Validate('required|exists:stores,id')]
    public string $store_id = '';

    public function store(): void {
        $validated = $this->validate();
        $aisle = new \App\Models\Aisle($validated);
        $aisle->store_id = $this->store_id;
        $aisle->save();
        $this->description = '';
        $this->position = 0;
        $this->store_id = '';
        $this->dispatch('aisle-created');
    }

    public function mount(): void {
        $this->stores = \App\Models\Store::with('user')->get();
    }
}; ?>

<div>
    <form wire:submit="store">
        <div class="form-group">
        <label for="description">{{ __('Description') }}</label>
        <input
            type="text"
            id="description"
            wire:model="description"
            placeholder="{{ __('Like the banana aisle') }}"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >
        </div>
        <div>
            <label for="position">{{ __('Position') }}</label>
            <input
                type="number"
                id="position"
                wire:model="position"
                placeholder="{{ __('0') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
        </div>
        <div>
            <label for="store_id">{{ __('Store') }}</label>
            <select
                id="store_id"
                wire:model="store_id"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value="">{{ __('Select a store') }}</option>
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
        </div>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    </form>
</div>
