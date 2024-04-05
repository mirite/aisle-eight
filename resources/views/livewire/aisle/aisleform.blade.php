<?php

use App\Models\Aisle;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use function Livewire\Volt\{state};

new class extends \Livewire\Volt\Component {
    public Collection $stores;

    #[Validate('required|string|max:256')]
    public string $description;

    #[Validate('integer|min:0|max:100')]
    public int $position;

    #[Validate('required|exists:stores,id')]
    public int $store_id;

    public function submit(): void
    {
        $validated = $this->validate();
        $this->description = '';
        $this->position = 0;
        $this->store_id = 0;
        $this->dispatch('aisle-form-submitted', $validated);
    }

    public function mount(?Aisle $editing = null): void
    {
        $this->stores = Store::with('user')->get();
        $this->description = $editing?->description ?? '';
        $this->position = $editing?->position ?? 0;
        $this->store_id = $editing?->store_id ?? 0;
    }
};

?>

<form wire:submit.prevent="submit">
    @include('livewire.forminput', [
        'label' => __('Description'),
        'id' => 'description',
        'model' => 'description',
        'placeholder' => __('Like the banana aisle (Where the bananas are)'),
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
    <div class="flex justify-end">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</form>
