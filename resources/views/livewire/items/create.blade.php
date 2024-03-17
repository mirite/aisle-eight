<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\ItemFields;

new class extends Component {
    use ItemFields;

    public function store(): void
    {
        $validated = $this->validate();
        auth()->user()->items()->create($validated);
        $this->name = '';
        $this->dispatch('item-created');
    }
}; ?>

<form wire:submit="store">
    @include('livewire.items.itemFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Add Item') }}</x-primary-button>
</form>
