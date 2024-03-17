<?php

use App\Models\AisleFields;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public \App\Models\Aisle $aisle;
    public Collection $stores;

    use AisleFields;

    public function mount(): void
    {
        $this->description = $this->aisle->description;
        $this->position = $this->aisle->position;
        $this->store_id = $this->aisle->store_id;
        $this->stores = Store::with('user')->get();
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
    @include('livewire.aisle.aisleFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
