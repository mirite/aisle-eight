<?php

use App\Models\Aisle;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $aisles;
    public ?Aisle $editing = null;

    public function mount(): void {
        $this->getAisles();
    }

    #[On( 'aisle-created' )]
    #[On( 'aisle-deleted' )]
    public function getAisles(): void {
        $this->aisles = auth()->user()->aisles()->get();
    }

    #[On( 'aisle-edit' )]
    public function edit( Aisle $aisle ): void {
        $this->editing = $aisle;
        $this->getAisles();
    }

    #[On( 'aisle-edit-canceled' )]
    #[On( 'aisle-updated' )]
    public function disableEditing(): void {
        $this->editing = null;

        $this->getAisles();
    }

    public function delete( Aisle $aisle ): void {
        $this->authorize( 'delete', $aisle );
        $aisle->delete();
        $this->getAisles();
    }
}; ?>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
    @foreach ($aisles as $aisle)
        @component('livewire/listitem')
            :wire:key="$aisle->id"
        >
            <x-slot name="title">
                @if ($aisle->is($editing))
                    <livewire:aisle.edit :aisle="$aisle" :key="$aisle->id"/>
                @else
                    <p class="text-lg text-gray-900">{{ $aisle->description }}</p>
                @endif
            </x-slot>
           <x-slot name="content">
                Items: {{ $aisle->aisleItems()->count() }}
                <ol>
                    @foreach ($aisle->aisleItems() as $aisle)
                        <li>{{ $item->message }}</li>
                    @endforeach
                </ol>
            </x-slot>
            <x-slot name="tools">
                <x-dropdown-link wire:click="edit({{ $aisle->id }})">
                    {{ __('Edit') }}
                </x-dropdown-link>
                <x-dropdown-link wire:click="delete({{ $aisle->id }})"
                                 wire:confirm="Are you sure to delete this aisle?">
                    {{ __('Delete') }}
                </x-dropdown-link>
            </x-slot>
        @endcomponent
    @endforeach
</div>
