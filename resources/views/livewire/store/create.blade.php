<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function submit(): void
    {
        $validated = $this->validate();
        auth()->user()->stores()->create($validated);
        $this->name = '';
        $this->dispatch('store-created');
    }
}; ?>

<form wire:submit.prevent="submit">
    @include('livewire.forminput', [
        'label' => 'Name',
        'id' => 'name',
        'model' => 'name',
        'placeholder' => __('Sort of like a story'),
        'error' => $errors->get('name'),
    ])
    <x-primary-button class="mt-4">{{ __('Add Store') }}</x-primary-button>
</form>
