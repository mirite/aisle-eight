<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\GroceryListFields;

new class extends Component {
    use GroceryListFields;

    public function mount(): void
    {
        $this->title = date('F j, Y');
    }

    public function submit(): void
    {
        $validated = $this->validate();
        auth()->user()->groceryLists()->create($validated);
        $this->title = '';
        $this->dispatch('grocery-list-added');
    }
}; ?>

<form wire:submit.prevent="submit">
    @include('livewire.grocerylist.groceryListFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Create List') }}</x-primary-button>
</form>
