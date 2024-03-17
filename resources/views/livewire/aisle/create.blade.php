<?php

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $stores;

    #[Validate('required|string|max:256')]
    public string $description = '';

    #[Validate('integer|min:0|max:100')]
    public int $position = 0;

    #[Validate('required|exists:stores,id')]
    public int $store_id;

    public function store(): void
    {
        $validated = $this->validate();
        auth()->user()->aisles()->create($validated);
        $this->description = '';
        $this->position = 0;
        $this->store_id = 0;
        $this->dispatch('aisle-created');
    }

    public function mount(): void
    {
        $this->stores = Store::with('user')->get();
    }
}; ?>

<form wire:submit="store">
    @include('livewire.forminput', [
        'label' => __('Description'),
        'id' => 'description',
        'model' => 'description',
        'placeholder' => __('Like the banana aisle'),
        'error' => $errors->get('description'),
    ])
    @include('livewire.forminput', [
        'label' => __('Position'),
        'id' => 'position',
        'model' => 'position',
        'type' => 'number',
        'placeholder' => __('Where it lives in the store'),
        'error' => $errors->get('position'),
    ])
    @include('livewire.formselect', [
        'label' => __('Store'),
        'id' => 'store_id',
        'model' => 'store_id',
        'children' => $stores,
        'placeholder' => __('Select a store'),
        'childLabelField' => 'name',
        'error' => $errors->get('store_id'),
    ])
    <x-primary-button class="mt-4">{{ __('Add Aisle') }}</x-primary-button>
</form>
