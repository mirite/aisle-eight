<?php

use App\Models\AisleItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
	public Collection $aisleItems;
	public ?AisleItem $editing = null;
	public string $search = '';

	public function delete( AisleItem $aisleItem ): void {
		$this->authorize( 'delete', $aisleItem );
		$aisleItem->delete();
		$this->getAisleItems();
	}

	#[On( 'aisle-item-edit-canceled' )]
	#[On( 'aisle-item-updated' )]
	public function disableEditing(): void {
		$this->editing = null;

		$this->getAisleItems();
	}

	public function duplicate( AisleItem $aisleItem ): void {
		$this->authorize( 'create', AisleItem::class );
		$newAisleItem = $aisleItem->replicate();
		$newAisleItem->save();
		$this->getAisleItems();
		$this->editing = $newAisleItem;
	}

	#[On( 'aisle-item-edit' )]
	public function edit( AisleItem $aisleItem ): void {
		$this->editing = $aisleItem;
		$this->getAisleItems();
	}

	#[On( 'aisle-item-created' )]
	#[On( 'aisle-item-updated' )]
	public function getAisleItems(): void {
		if ( $this->search ) {
			$this->aisleItems = auth()
				->user()
				->aisleItems()
				->whereHas( 'item', function ( $query ) {
					$query->whereRaw( 'UPPER(name) like ?', array( '%' . strtoupper( $this->search ) . '%' ) );
				} )
				->orWhereRaw( 'UPPER(description) like ?', array( '%' . strtoupper( $this->search ) . '%' ) )
				->get();
		} else {
			$this->aisleItems = auth()->user()->aisleItems()->get();
		}
	}

	public function mount(): void {
		$this->getAisleItems();
	}

	public function triggerSearch(): void {
		$this->getAisleItems();
	}
}; ?>
<div>
				<div>
								<x-search-form />
				</div>
				<x-list-wrapper>
								@foreach ($aisleItems->sort(fn($a, $b) => $a->item->name <=> $b->item->name) as $aisleItem)
												@php($name = md5($aisleItem->aisle->store->name . $aisleItem->aisle->description . $aisleItem->item->name . $aisleItem->description))
												<div class="p-6 flex space-x-2" wire:key="{{ $aisleItem->id }}">
																@component('livewire/listitem', ['testPrefix' => 'aisle-item-' . $name])
																				:wire:key="$aisleItem->id"
																				>
																				<x-slot name="title">
																								@if ($aisleItem->is($editing))
																												<div>
																																<livewire:aisleitem.form :editingID="$aisleItem->id" :key="$aisleItem->id" />
																																<x-secondary-button type="button" wire:click="disableEditing">
																																				{{ __('Cancel') }}
																																</x-secondary-button>
																												</div>
																								@else
																												<x-list-title>
																																{{ $aisleItem->item->name }} - {{ $aisleItem->description }}
																												</x-list-title>
																								@endif
																				</x-slot>
																				<x-slot name="content">
																								@include('components.aisleItem.single', [
																												'pages.aisleItem' => $aisleItem,
																												'hide' => ['name'],
																								])
																				</x-slot>
																				<x-slot name="tools">
																								<x-dropdown-link data-testid="aisle-item-{{ $name }}-edit"
																												wire:click="edit({{ $aisleItem->id }})">
																												{{ __('Edit') }}
																								</x-dropdown-link>
																								<x-dropdown-link wire:click="duplicate({{ $aisleItem->id }})">
																												{{ __('Duplicate') }}
																								</x-dropdown-link>
																								<x-dropdown-link data-testid="aisle-item-{{ $name }}-delete"
																												wire:click="delete({{ $aisleItem->id }})"
																												wire:confirm="Are you sure to delete this aisle item?">
																												{{ __('Delete') }}
																								</x-dropdown-link>
																				</x-slot>
																@endcomponent
												</div>
								@endforeach
				</x-list-wrapper>
</div>
