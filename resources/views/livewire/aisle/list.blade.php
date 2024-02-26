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
        $this->refresh = fn() => $this->getAisles();
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
        <livewire:listitem
            :wire:key="$aisle->id"
            :item="$aisle"
            modelClass="Aisle"
            label="Aisle"
            :editing="$editing"
            :name="$aisle->description"
        >
            Items: {{ $aisle->aisleItems()->count() }}
            <ol>
                @foreach ($aisle->aisleItems() as $item)
                    <li>{{ $item->message }}</li>
                @endforeach
            </ol>
        </livewire:listitem>
    @endforeach
</div>
