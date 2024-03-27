<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\GroceryList;
use Illuminate\Database\Eloquent\Collection;
use App\Models\GroceryListFields;

new class extends Component {
    use GroceryListFields;

    public GroceryList $groceryList;

    public function mount(): void {
        $this->title = $this->groceryList->title;
    }

    public function update(): void {
        $this->authorize( 'update', $this->groceryList );

        $validated = $this->validate();

        $this->groceryList->update( $validated );

        $this->dispatch( 'grocery-list-updated' );
    }

    public function cancel(): void {
        $this->dispatch( 'grocery-list-edit-canceled' );
    }
};
?>
<form wire:submit="update">
    @include('livewire.grocerylist.groceryListFields', [
        'errors' => $errors,
    ])
    <x-primary-button class="mt-4">{{ __('Update') }}</x-primary-button>
    <button class="mt-4" wire:click.prevent="cancel">Cancel</button>
</form>
