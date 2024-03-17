<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    use \App\Models\StoreFields;

    public function submit(): void
    {
        $validated = $this->validate();
        auth()->user()->stores()->create($validated);
        $this->name = '';
        $this->dispatch('store-created');
    }
}; ?>

<form wire:submit.prevent="submit">
    @include('livewire.store.storeFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Add Store') }}</x-primary-button>
</form>
