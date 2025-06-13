<?php

use App\Models\GroceryList;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
	public Collection $aisles;
	public ?GroceryList $current = null;

	public array $inCart = array();
	public int $last_aisle_id = -1;

	public int $last_store_id = -1;

	public Collection $listItems;
	public Collection $stores;

	public float $total = 0;

	public function getLists(): Collection {
		return auth()->user()->groceryLists()->get();
	}

	public function markInCart(): void {
		$inCartItems = array_map( function ( int $itemId ) {
			return $this->listItems->find( $itemId );
		}, $this->inCart );

		foreach ( $this->listItems as $listItem ) {
			$listItem->in_cart = in_array( $listItem, $inCartItems, true );
			$listItem->save();
		}
	}

	public function mount( string $id ): void {
		$lists = $this->getLists();
		$this->current = $lists->find( $id );
		$this->listItems = $this->current->listItems()->get();
		$this->stores = $this->listItems->map( fn( $listItem ) => $listItem->aisleItem->aisle->store )->unique();
		$this->aisles = $this->listItems->mapWithKeys( fn( $listItem ) => array( $listItem->aisleItem->aisle->id => $listItem->aisleItem->aisle ) )->unique();

		$this->inCart = $this->listItems->filter( fn( $listItem ) => $listItem->in_cart )->pluck( 'id' )->toArray();

		if ( !$this->current ) {
			abort( 404 );
		}
	}
}; ?>
<div>
				<h1>Shopping With {{ $current->title ?? '' }}</h1>
				<a href="{{ route('grocery-list/listbuilder', $current->id) }}">Edit This List</a>
				<div class="mb-4">
								@foreach ($stores as $store)
												<div wire:key="{{ $store->id }}">
																<h2>{{ $store->name }}</h2>
																@foreach ($aisles->filter(fn($aisle) => $aisle->store->id == $store->id)->sort(fn($a, $b) => $a->position <=> $b->position) as $aisle)
																				<div wire:key="{{ $aisle->id }}">
																								<h3>{{ $aisle->description }}</h3>
																								<div class="grid content-center grid-cols-[min-content_1fr_min-content] gap-2">
																												<div>
																																In Cart?
																												</div>
																												<div>
																																Item
																												</div>
																												<div>
																																Estimated Price
																												</div>
																												@foreach ($listItems->filter(fn($listItem) => $listItem->aisleItem->aisle->id == $aisle->id)->sort(fn($a, $b) => $a->position <=> $b->position) as $listItem)
																																<div wire:key="{{ $listItem->id }}" class="p-2 text-xl col-span-3 grid grid-cols-subgrid">
																																				<input class="max-w-6" type="checkbox" id="item-{{ $listItem->id }}"
																																								name="item-{{ $listItem->id }}" value="{{ $listItem->id }}"
																																								wire:change="markInCart" wire:model="inCart"
																																								checked="{{ $listItem->in_cart }}">
																																				<label for="item-{{ $listItem->id }}" class="flex gap-2 flex-col md:flex-row">
																																								@include('components.aisleItem.singleSlim', [
																																												'item' => $listItem->aisleItem,
																																												'showStore' => false,
																																												'showPrice' => false,
																																								])
																																								@if ($listItem->quantity > 1)
																																												x{{ $listItem->quantity }}
																																								@endif
																																				</label>
																																				<div>${{ $listItem->aisleItem->price * $listItem->quantity }}</div>
																																				@php($total += $listItem->aisleItem->price * $listItem->quantity)
																																</div>
																												@endforeach
																								</div>
																				</div>
																@endforeach
												</div>
								@endforeach
				</div>
				<div><span class="font-bold">Approximate Total:</span> ${{ $total }}</div>
</div>
