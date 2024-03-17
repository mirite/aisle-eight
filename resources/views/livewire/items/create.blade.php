<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function store():void {
        $validated = $this->validate();
        auth()->user()->items()->create($validated);
        $this->name = '';
        $this->dispatch('item-created');
    }
}; ?>

<form wire:submit="store">
    @include(
        'livewire.forminput',
        [
            'label' => 'Name',
            'id'=>'name',
            'model' => 'name',
            'placeholder' => __('What do you call it?'),
            'error'=>$errors->get('name')
        ]
    )
    <x-primary-button class="mt-4">{{ __('Add Item') }}</x-primary-button>
</form>
