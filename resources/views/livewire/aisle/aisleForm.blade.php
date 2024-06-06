<?php

use App\Models\Aisle;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new class extends Component {
    public Collection $stores;

    #[Validate('required|string|min:1|max:256')]
    public string $description;

    #[Validate('integer|min:0|max:100')]
    public int $position;

    #[Validate('required|exists:stores,id')]
    public int $store_id;

    public ?Aisle $editing = null;

    public function submit(): void
    {
        $validated = $this->validate();

        if ($this->editing) {
            $this->authorize('update', $this->editing);
            $this->editing->update($validated);
            $this->dispatch('aisle-updated');
        } else {
            auth()->user()->aisles()->create($validated);
            $this->dispatch('aisle-created');
        }
        $this->description = '';
        $this->position = $this->position + 1;
        $this->dispatch('formSubmitted');
    }

    public function mount(?string $editingID = null): void
    {
        $this->stores = Store::with('user')->get();

        if (isset($editingID)) {
            $this->editing = Aisle::findOrFail($editingID);
            $this->description = $this->editing->description;
            $this->position = $this->editing->position;
            $this->store_id = $this->editing->store_id;
        } else {
            $this->description = '';
            $this->position = 0;
            $this->store_id = 0;
        }
    }
};

?>

<form wire:submit="submit" data-form="entry">
    <x-form-input :label="__('Description')" id="{{ uniqid() }}" :model="'description'"
        placeholder="{{ __('Like the banana aisle (Where the bananas are)') }}" :error="$errors->get('description')" />
    <x-form-input :label="__('Position')" id="{{ uniqid() }}" :model="'position'" type="number"
        placeholder="{{ __('Where it lives in the store') }}" :error="$errors->get('position')" />
    <x-form-select :label="__('Store')" id="{{ uniqid() }}" :model="'store_id'" :children="$stores ?? []"
        placeholder="{{ __('Select a store') }}" childLabelField="name" :error="$errors->get('store_id')" />
    <div class="flex justify-end">
        <x-primary-button data-testid="save">{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
    @livewire('focusfirstinput')
</form>
