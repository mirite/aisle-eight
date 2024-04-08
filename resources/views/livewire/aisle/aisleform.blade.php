<?php

use App\Models\Aisle;
use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new #[Title('Aisle Form')] class extends Component {
    public Collection $stores;

    #[Validate('required|string|max:256')]
    public string $description;

    #[Validate('integer|min:0|max:100')]
    public int $position;

    #[Validate('required|exists:stores,id')]
    public int $store_id;

    public ?Aisle $editing = null;

    public function submit(): void
    {
        $validated = $this->validate();
        $this->dispatch('aisle-form-submitted', $validated);
        $this->description = '';
        $this->position = 0;
        $this->store_id = 0;
    }

    public function mount(): void
    {
        $this->stores = Store::with('user')->get();
        if (isset($editing)) {
            $this->editing = $editing;
            $this->description = $this->editing->description;
            $this->position = $this->editing->position;
            $this->store_id = $this->editing->store_id;
        } else {
            $this->description = '';
            $this->position = 0;
            $this->store_id = 0;
        }
    }
};

?>

<form wire:submit="submit">
    <livewire:form-input :label="__('Description')" id="description" :value="$description"
        placeholder="{{ __('Like the banana aisle (Where the bananas are)') }}" :error="$errors->get('description')" />
    <livewire:form-input :label="__('Position')" id="position" :value="$position" type="number"
        placeholder="{{ __('Where it lives in the store') }}" :error="$errors->get('position')" />
    <livewire:form-select :label="__('Store')" id="store_id" :value="$store_id" :children="$stores ?? []"
        placeholder="{{ __('Select a store') }}" childLabelField="name" :error="$errors->get('store_id')" />
    <div class="flex justify-end">
        {{ $editing }}
        <x-primary-button>{{ $editing ? __('Update') : __('Save') }}</x-primary-button>
    </div>
</form>
