<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\Store;

new class extends Component {
    #[Validate('required|string|min:1|max:255')]
    public string $name;

    public ?Store $editing = null;
    public function mount(?string $storeID = null): void
    {
        if (isset($storeID)) {
            $this->editing = Store::findOrFail($storeID);
            $this->name = $this->editing->name;
        } else {
            $this->name = '';
        }
    }

    public function submit(): void
    {
        $validated = $this->validate();
        if ($this->editing) {
            $this->authorize('update', $this->editing);
            $this->editing->update($validated);
            $this->dispatch('store-updated');
        } else {
            auth()->user()->stores()->create($validated);
            $this->dispatch('store-created');
        }
        $this->name = '';
    }
};
?>
<form wire:submit="submit">
    @include('components.form-input', [
        'label' => 'Name',
        'id' => 'name',
        'model' => 'name',
        'placeholder' => __('Sort of like a story'),
        'error' => $errors->get('name'),
    ])

    <x-primary-button class="mt-4">{{ __('Update') }}</x-primary-button>
</form>
