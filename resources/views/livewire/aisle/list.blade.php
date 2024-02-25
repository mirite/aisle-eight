<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public \Illuminate\Database\Eloquent\Collection $aisles;
    public ?\App\Models\Aisle $editing = null;

    public function mount():void {
        $this->getAisles();    }

    #[On('aisle-created')]
    public function getAisles():void {
        $this->aisles = auth()->user()->aisles()->get();
    }

    public function edit(\App\Models\Aisle $aisle):void {
        $this->editing = $aisle;
        $this->getAisles();
    }

    #[On('aisle-edit-canceled')]
    #[On('aisle-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getAisles();
    }

    public function delete( \App\Models\Aisle $aisle): void {
        $this->authorize('delete', $aisle);
        $aisle->delete();
        $this->getAisles();
    }
}; ?>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
    @foreach ($aisles as $aisle)
        <div class="p-6 flex flex-col gap-2" wire:key="{{ $aisle->id }}">
            <div class="flex gap-2">
                <div class="grow">
                @if ($aisle->is($editing))
                    <livewire:aisle.edit :aisle="$aisle" :key="$aisle->id" />
                @else
                    <p class="text-lg text-gray-900">{{ $aisle->description }}</p>
                @endif
                </div>
                <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link wire:click="edit({{ $aisle->id }})">
                                {{ __('Edit') }}
                            </x-dropdown-link>
                            <x-dropdown-link wire:click="delete({{ $aisle->id }})" wire:confirm="Are you sure to delete this aisle?">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
            </div>
            <div>
                Items: {{ $aisle->aisleItems()->count() }}
                <ol>
                    @foreach ($aisle->aisleItems() as $item)
                        <li>{{ $item->message }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endforeach
</div>
