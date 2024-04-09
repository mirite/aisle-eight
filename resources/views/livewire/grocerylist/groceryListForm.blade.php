<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\GroceryList;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {
    public ?GroceryList $editing = null;

    #[Validate('string|min:1|max:255')]
    public string $title = '';

    public function mount(?string $listID = null): void
    {
        if (isset($listID)) {
            $this->editing = GroceryList::findOrFail($listID);
            $this->title = $this->editing->title;
        } else {
            $this->title = date('F j, Y');
        }
    }

    public function submit(): void
    {
        $validated = $this->validate();
        if ($this->editing) {
            $this->authorize('update', $this->editing);
            $this->editing->update($validated);
            $this->dispatch('grocery-list-updated');
        } else {
            auth()->user()->groceryLists()->create($validated);
            $this->dispatch('grocery-list-created');
        }
        $this->title = date('F j, Y');
    }
};
?>
<form wire:submit="submit">
    @include('components.form-input', [
        'label' => 'Title',
        'id' => 'title',
        'model' => 'title',
        'placeholder' => __('What should this list be called?'),
        'error' => $errors->get('title'),
    ])
    <div class="flex justify-end">
        <x-primary-button>{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
</form>
