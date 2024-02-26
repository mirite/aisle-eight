<?php

use function Livewire\Volt\{state};
use Livewire\Volt\Component;
use App\Models\BaseModel;

new class extends Component {
    public string $label = '';
    public $item;
    public $editing = null;
    public string $modelClass;
    public string $name = '';

    public function mount( string $label, $item, $editing, string $modelClass, string $name ): void {
        $this->label      = $label;
        $this->item       = $item;
        $this->editing    = $editing;
        $this->modelClass = $modelClass;
        $this->name       = $name;
    }

    public function delete( $item ): void {
        $this->authorize( 'delete', $item );
        $aisle->delete();
        $this->dispatch( strtolower( $this->modelClass ) . '-deleted' );
    }
};
?>

<div class="p-6 flex flex-col gap-2">
    <div class="flex gap-2">
        <div class="grow">
            @if ($item->is($editing))
                <livewire:{{ strtolower($modelClass) }}.edit :item="$item" :key="$item->id"/>
            @else
                <p class="text-lg text-gray-900">{{ $name }}</p>
            @endif
        </div>
        <x-dropdown>
            <x-slot name="trigger">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link wire:click="edit({{ $item->id }})">
                    {{ __('Edit') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="delete({{ $item->id }})"
                                 wire:confirm="Are you sure to delete this {{$label}}?">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>
    <div>
        @slot('content')@endslot
    </div>
</div>
