<?php

use App\Models\{Aisle, AisleItem, Item, Store};
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
	#[Validate( 'required|exists:aisles,id' )]
	public string $aisle_id;

	/**
	ID for the aisle select element. There's issues with the element re-rendering when the store changes if this is done inline like the others,
																							 * @var string
	 */
	public string $aisle_id_id;
	public Collection $allAisles;

	#[Validate( 'string|max:255' )]
	public string $description;
	public ?AisleItem $editing = null;
	public Collection $filteredAisles;

	#[Validate( 'required|exists:items,id' )]
	public string $item_id;
	public Collection $items;

	#[Validate( 'integer|min:0|max:100' )]
	public int $position;

	#[Validate( 'numeric|max:255' )]
	public float $price;

	#[Validate( 'integer|min:0|max:10000' )]
	public int $size;

	#[Validate( 'required|exists:stores,id' )]
	public string $store_id;
	public Collection $stores;

	#[Validate( 'in_array:unitTypes.*' )]
	public string $units = 'g';
	public array $unitTypes = array( 'g', 'kg', 'mL', 'L', 'oz', 'lb', 'qt', 'pt', 'fl oz' );

	public function filterAisles(): void {
		$this->filteredAisles = $this->allAisles->filter( function ( Aisle $aisle ) {
			return (string) $aisle->store->id === $this->store_id;
		} );
	}

	public function mount( ?string $editingID = null ): void {
		$this->aisle_id_id = uniqid();
		$this->stores = Store::all()->sortBy( 'name' )->sortBy( 'name' );
		$this->allAisles = Aisle::all()->sortBy( 'position' );
		$this->items = Item::all()->sortBy( 'name' );

		if ( isset( $editingID ) ) {
			$this->editing = AisleItem::findOrFail( $editingID );
			$this->price = $this->editing->price;
			$this->description = $this->editing->description;
			$this->store_id = $this->editing->aisle->store->id;
			$this->aisle_id = $this->editing->aisle->id;
			$this->item_id = $this->editing->item_id;
			$this->position = $this->editing->position;
			$this->size = $this->editing->size;
			$this->units = $this->editing->unit ?? 'g';
			$this->filterAisles();
		} else {
			$this->price = 0.0;
			$this->description = '';
			$this->aisle_id = '';
			$this->item_id = '';
			$this->position = 0;
			$this->size = 0;
			$this->units = 'g';
		}
	}

	public function submit(): void {
		$validated = $this->validate();

		if ( $this->editing ) {
			$this->authorize( 'update', $this->editing );
			$this->editing->update( $validated );
			$this->dispatch( 'aisle-item-updated' );
		} else {
			auth()->user()->aisleItems()->create( $validated );
			$this->dispatch( 'aisle-item-created' );
		}
		$this->price = 0.0;
		$this->description = '';
		$this->item_id = '';
		$this->position = $this->position + 1;
		$this->dispatch( 'formSubmitted' );
	}
};
?>
<form wire:submit="submit" data-form="entry">
				<x-form-select label="{{ __('Store') }}" id="{{ uniqid() }}" :model="'store_id'" :change="'filterAisles'"
								:children="$stores ?? []" placeholder="{{ __('Select a store') }}" :childLabelField="fn($store) => $store->name" :error="$errors->get('store_id')" />
				<x-form-select label="{{ __('Aisle') }}" id="{{ $aisle_id_id }}" :model="'aisle_id'" :children="$filteredAisles ?? []"
								placeholder="{{ __('Select an aisle') }}" :childLabelField="fn($aisles) => $aisles->description" :error="$errors->get('aisle_id')" />
				<x-form-select label="{{ __('Item') }}" id="{{ uniqid() }}" :model="'item_id'" :children="$items ?? []"
								placeholder="{{ __('Select an item') }}" childLabelField="name" :error="$errors->get('item_id')" />
				<x-stack-mobile>
								<x-form-input label="{{ __('Price') }}" id="{{ uniqid() }}" :model="'price'" type="number"
												step="0.01" :error="$errors->get('price')" />
								<x-form-input label="{{ __('Description') }}" id="{{ uniqid() }}" :model="'description'"
												placeholder="{{ __('Like Salted, Wonder or PC') }}" :error="$errors->get('description')" />
				</x-stack-mobile>
				<x-stack-mobile>
								<x-form-input label="{{ __('Size') }}" id="{{ uniqid() }}" :model="'size'" type="number"
												step="0.1" placeholder="{{ __('ex. 100') }}" :error="$errors->get('size')" />
								<x-form-select label="{{ __('Units') }}" id="{{ uniqid() }}" :model="'units'" :children="$unitTypes"
												:error="$errors->get('units')" /></x-stack-mobile>
				<x-form-input label="{{ __('Position') }}" id="{{ uniqid() }}" :model="'position'" type="number"
								placeholder="{{ __('Where it lives in the aisle') }}" :error="$errors->get('position')" />
				<div class="flex justify-end">
								<x-primary-button data-testid="save">{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
				</div>
				@livewire('focusfirstinput')
</form>
