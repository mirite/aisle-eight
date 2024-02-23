<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('string|max:255')]
    public string $price = '';
    #[Validate('string|max:255')]
    public string $description = '';
    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    #[Validate('required|exists:aisle,id')]
    public string $aisle_id = '';

    #[Validate('required|exists:item,id')]
    public string $item_id = '';

    public function submit(): void {
        $validated = $this->validate();
        $aisle = new \App\Models\AisleItem($validated);
        $this->price = '';
        $this->description = '';
        $this->$aisle_id = '';
        $this->$item_id = '';
        $this->position = 0;
        $this->dispatch('aisle-item-created');
    }

    public function mount(): void {
        $this->aisles = \App\Models\Aisle::all();
        $this->items = \App\Models\Item::all();
    }

    public \Illuminate\Database\Eloquent\Collection $aisles;
    public \Illuminate\Database\Eloquent\Collection $items;


}; ?>

<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label for="price">{{_('Price')}}</label>
            <input type="text" wire:model="price" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="price" aria-describedby="nameHelp" placeholder="Optional">
        </div>
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
        <div class="form-group">
            <label for="description">{{_('Description')}}</label>
            <input type="text" wire:model="description" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="description" aria-describedby="nameHelp" placeholder="Optional">
        </div>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
        <div>
            <label for="position">{{_('Position')}}</label>
            <input type="number" wire:model="position" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="position" aria-describedby="nameHelp" placeholder="0">
        </div>
        <x-input-error :messages="$errors->get('position')" class="mt-2" />
        <div>
            <label for="aisle_id">{{_('Aisle')}}</label>
            <select wire:model="aisle_id" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="aisle_id" aria-describedby="nameHelp">
                <option value="">{{_('Select')}}</option>
                @foreach ($aisles as $aisle)
                    <option value="{{ $aisle->id }}">{{ $aisle->description }}</option>
                @endforeach
            </select>
        </div>
        <x-input-error :messages="$errors->get('aisle_id')" class="mt-2" />
        <div>
            <label for="item_id">{{_('Item')}}</label>
            <select wire:model="item_id" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="item_id" aria-describedby="nameHelp">
                <option value="">{{_('Select')}}</option>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <x-input-error :messages="$errors->get('item_id')" class="mt-2" />

        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    </form>
</div>
