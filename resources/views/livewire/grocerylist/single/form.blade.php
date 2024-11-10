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

    /**
     *
     * @var int|null
     */
    public ?int $currentItemID = null;

    /**
     * The current search term.
     * @var string
     */
    public string $search = '';

    /**
     * The quantity of the item to add.
     * @var int
     */
    public int $quantity = 1;

    /**
     * Whether or not to show the quick create form.
     * @var bool
     */
    public bool $showQuickCreate = false;

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
            return str_contains(strtolower($item->item->name), strtolower($this->search));
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
            'quantity' => $this->quantity,
        ]);
        $this->search = '';
        $this->filteredItems = $this->allItems;
        $this->quantity = 1;
        $this->currentItemID = null;
    }

    public function toggleQuickCreate():void {
        $this->showQuickCreate = !$this->showQuickCreate;
    }
};
?>
<div>
    <h1>Building {{ $current->title ?? '' }}</h1>
    <a href="{{ route('grocery-list/uselist', $current->id) }}">Use This List</a>
    <div>
        <form wire:submit.prevent="submit" class="grid grid-cols-[max-content_1fr] gap-2">
            <div class="grid grid-cols-subgrid col-span-2">
                <x-input-label for="search">Search</x-input-label>
                <x-input-text type="text" id="search" wire:model="search" wire:change="filterItems" />
            </div>
            <div class="flex col-span-2 justify-between gap-2 items-center">
                <div class="grow">
                    <x-input-label for="pick-item">Pick an Item</x-input-label>
                    <x-input-select id="pick-item" wire:model="currentItemID">
                        <option value="">Select an Item</option>
                        @foreach ($this->filteredItems as $item)
                            <option value="{{ $item->id }}">@include('components.aisleItem.singleSlim', [$item])</option>
                        @endforeach
                    </x-input-select>
                </div>
                <div>
                    <x-secondary-button wire:click="toggleQuickCreate">{{ __('Quick Create') }}</x-secondary-button>
                </div>
            </div>
            @if($showQuickCreate)
                <livewire:aisleitem.form />
            @endif
            <div class="grid grid-cols-subgrid col-span-2">
                <x-input-label for="quantity">Count</x-input-label>
                <x-input-text type="number" id="quantity" wire:model="quantity" wire:change="filterItems" />
            </div>
            <div class="col-span-2">
                <x-primary-button class="mt-4">{{ __('Add') }}</x-primary-button>
            </div>
        </form>
        <ul>
            @foreach ($this->current->listItems as $item)
                <li>{{ $item->aisleItem->item->name }} ({{ $item->aisleItem->description }})</li>
            @endforeach
        </ul>
    </div>
</div>
