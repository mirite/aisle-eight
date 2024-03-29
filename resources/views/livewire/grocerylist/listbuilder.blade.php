<?php

use Livewire\Volt\Component;
use Illuminate\Support\Collection;
use App\Models\GroceryList;
use function Livewire\Volt\{state};

new class extends Component {
    /**
     * The grocery list being built.
     * @var GroceryList|null
     */
    public ?GroceryList $current = null;

    /**
     * All items in the system associated with the user.
     * @var Collection<\App\Models\AisleItem>
     */
    public Collection $allItems;

    /**
     * The items currently being displayed after filtering.
     * @var Collection<\App\Models\AisleItem>
     */
    public Collection $filteredItems;

    public ?int $currentItemID = null;

    public string $search = '';

    public int $count = 0;

    public function mount(string $id): void
    {
        $lists = $this->getLists();
        $this->current = $lists->find($id);
        $this->allItems = auth()->user()->aisleItems()->get();
        $this->filteredItems = $this->allItems;

        if (!$this->current) {
            abort(404);
        }
    }

    public function getLists(): Collection
    {
        return auth()->user()->groceryLists()->get();
    }

    public function filterItems(): void
    {
        $this->filteredItems = $this->allItems->filter(function (\App\Models\AisleItem $item) {
            return str_contains($item->item->name, $this->search);
        });
    }

    public function submit(): void
    {
        if (!$this->currentItemID) {
            return;
        }

        $current = $this->allItems->find($this->currentItemID);
        $this->current->listItems()->create([
            'grocery_list_id' => $this->current->id,
            'aisle_item_id' => $current->id,
            'count'=> $this->count,
        ]);
        $this->search = "";
        $this->filteredItems = $this->allItems;
        $this->count = 0;

    }
};
?>
<div>
    <h1>Building {{ $current->title ?? '' }}</h1>
    <a href="{{ route('grocery-list/uselist', $current->id) }}">Use This List</a>
    <div>
        <form wire:submit.prevent="submit" class="grid grid-cols-[max-content_1fr] gap-2">
            <div class="grid grid-cols-subgrid col-span-2">
                <label for="search">Search</label><input type="text" id="search" wire:model="search"
                    wire:change="filterItems">
            </div>
            <div class="grid grid-cols-subgrid col-span-2">
                <label for="pick-item">Pick an Item</label>
                <select id="pick-item" wire:model="currentItemID">
                    <option disabled>Select an Item</option>
                    @foreach ($this->filteredItems as $item)
                        <option value="{{ $item->id }}">@include('aisleItem.singleSlim', [$item])</option>
                    @endforeach
                </select>
            </div>
            <x-primary-button class="mt-4">{{ __('Add') }}</x-primary-button>
        </form>
    </div>
</div>
