<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\Store;
use App\Models\StoreFields;

new class extends Component {
    use StoreFields;

    public Store $store;
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
    @include('livewire.store.storeFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Update') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
