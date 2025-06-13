<?php

use App\Models\Store;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
	public ?Store $editing = null;
	#[Validate( 'required|string|min:1|max:255' )]
	public string $name;
	public function mount( ?string $storeID = null ): void {
		if ( isset( $storeID ) ) {
			$this->editing = Store::findOrFail( $storeID );
			$this->name = $this->editing->name;
		} else {
			$this->name = '';
		}
	}

	public function submit(): void {
		$validated = $this->validate();

		if ( $this->editing ) {
			$this->authorize( 'update', $this->editing );
			$this->editing->update( $validated );
			$this->dispatch( 'store-updated' );
		} else {
			auth()->user()->stores()->create( $validated );
			$this->dispatch( 'store-created' );
		}
		$this->name = '';
		$this->dispatch( 'formSubmitted' );
	}
};
?>
<form wire:submit="submit" data-form="entry">
				@include('components.form-input', [
								'label' => 'Name',
								'id' => uniqid(),
								'model' => 'name',
								'placeholder' => __('Sort of like a story'),
								'error' => $errors->get('name'),
								'testId' => 'primary-text',
				])
				<div class="flex justify-end">
								<x-primary-button data-testid="save">{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
				</div>
				@livewire('focusfirstinput')
</form>
