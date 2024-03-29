<?php

use Livewire\Volt\Component;
use Illuminate\Support\Collection;
use App\Models\GroceryList;
use function Livewire\Volt\{state};

new class extends Component {
    public ?GroceryList $current = null;

    public Collection $listItems;
    public Collection $stores;
    public Collection $aisles;

    public array $inCart = [];

    public int $last_store_id = -1;
    public int $last_aisle_id = -1;

    public function mount(string $id): void
    {
        $lists = $this->getLists();
        $this->current = $lists->find($id);
        $this->listItems = $this->current->listItems()->get();
        $this->stores = $this->listItems->map(fn($listItem) => $listItem->aisleItem->aisle->store)->unique();
        $this->aisles = $this->listItems->mapWithKeys(fn($listItem) => [$listItem->aisleItem->aisle->id => $listItem->aisleItem->aisle])->unique();

        $this->inCart = $this->listItems->filter(fn($listItem) => $listItem->in_cart)->pluck('id')->toArray();
        if (!$this->current) {
            abort(404);
        }
    }

    public function getLists(): Collection
    {
        return auth()->user()->groceryLists()->get();
    }

    public function markInCart(): void
    {
        $inCartItems = array_map(function (int $itemId) {
            return $this->listItems->find($itemId);
        }, $this->inCart);

        foreach ($this->listItems as $listItem) {
            $listItem->in_cart = in_array($listItem, $inCartItems, true);
            $listItem->save();
        }
    }
}; ?>
<div>
    <h1>Shopping With {{ $current->title ?? '' }}</h1>
    <a href="{{ route('grocery-list/listbuilder', $current->id) }}">Edit This List</a>

    <div>
        @foreach ($stores as $store)
            <div wire:key="{{ $store->id }}">
                <h2>{{ $store->name }}</h2>
                @foreach ($aisles->filter(fn($aisle) => $aisle->store->id == $store->id)->sort(fn($a, $b) => $a->position <=> $b->position) as $aisle)
                    <div wire:key="{{ $aisle->id }}">
                        <h3>{{ $aisle->description }}</h3>
                        @foreach ($listItems->filter(fn($listItem) => $listItem->aisleItem->aisle->id == $aisle->id)->sort(fn($a, $b) => $a->position <=> $b->position) as $listItem)
                            <div wire:key="{{ $listItem->id }}">
                                <input type="checkbox" id="item-{{ $listItem->id }}" name="item-{{ $listItem->id }}"
                                    value="{{ $listItem->id }}" wire:change="markInCart" wire:model="inCart"
                                    checked="{{ $listItem->in_cart }}">
                                <label for="item-{{ $listItem->id }}">@include('aisleItem.singleSlim', ['item' => $listItem->aisleItem]) @if ($listItem->quantity > 1)
                                        x{{ $listItem->quantity }}
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
