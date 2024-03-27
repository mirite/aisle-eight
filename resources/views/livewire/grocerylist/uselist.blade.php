<?php

use Livewire\Volt\Component;
use Illuminate\Support\Collection;
use App\Models\GroceryList;
use function Livewire\Volt\{state};

new class extends Component {
    public Collection $lists;
    public ?GroceryList $current = null;

    public function mount(string $id): void
    {
        $this->lists = $this->getLists();
        $this->current = $this->lists->find($id);
        if (!$this->current) {
            abort(404);
        }
    }

    public function getLists(): Collection
    {
        return auth()->user()->groceryLists()->get();
    }
}; ?>
<div>
    <h1>Shopping With {{ $current->title ?? '' }}</h1>
    <a href="{{ route('grocery-list/listbuilder', $current->id) }}">Edit This List</a>
</div>
