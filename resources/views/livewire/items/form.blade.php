<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;

use App\Models\Item;

new class extends Component {
    public ?Item $editing = null;
    #[Validate('required|string|max:255')]
    public string $name;

    #[Validate('boolean')]
    public bool $isTaxable;

    public function mount(?string $itemID = null): void
    {
        if (isset($itemID)) {
            $this->editing = Item::findOrFail($itemID);
            $this->name = $this->editing->name;
            $this->isTaxable = $this->editing->is_taxable;
        } else {
            $this->name = '';
            $this->isTaxable = false;
        }
    }

    public function update(): void
    {
        $validated = $this->validate();
        if ($this->editing) {
            $this->authorize('update', $this->editing);
            $this->editing->update($validated);
            $this->dispatch('item-updated');
        } else {
            auth()->user()->items()->create($validated);
            $this->dispatch('item-created');
        }
        $this->name = '';
        $this->isTaxable = false;
        $this->dispatch('formSubmitted');
    }
};
?>
<form wire:submit="update" data-form="entry">
    @include('components.form-input', [
        'label' => 'Name',
        'id' => uniqid(),
        'model' => 'name',
        'placeholder' => __('What do you call it?'),
        'error' => $errors->get('name'),
        'testId' => 'primary-text',
    ])
    @include('components.form-input', [
        'label' => 'Is Taxable?',
        'id' => uniqid(),
        'type' => 'checkbox',
        'model' => 'isTaxable',
        'error' => $errors->get('isTaxable'),
        'testId' => 'primary-is-taxable',
    ])

    <div class="flex justify-end">
        <x-primary-button data-testid="save">{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
    @livewire('focusfirstinput')
</form>
