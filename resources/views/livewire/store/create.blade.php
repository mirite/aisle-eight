<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\StoreFields;

new class extends Component {
    use StoreFields;

    public function submit(): void
    {
        $validated = $this->validate();
        auth()->user()->stores()->create($validated);
        $this->name = '';
        $this->dispatch('store-created');
    }
}; ?>

<form wire:submit.prevent="submit">
    <x-form-contents>
        @include('livewire.store.storeFields', [
            'errors' => $errors,
        ])
    </x-form-contents>
    <x-primary-button class="mt-4">{{ __('Add Store') }}</x-primary-button>
</form>
