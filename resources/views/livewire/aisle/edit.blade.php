<?php

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public ?\App\Models\Aisle $aisle;

    public function update($validated): void
    {
        $this->authorize('update', $this->aisle);
        $this->aisle->update($validated);

        $this->dispatch('aisle-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('aisle-edit-canceled');
    }
};
?>
<livewire:aisle.aisleform wire:aisle-form-submitted="update" :editing="$aisle" />
