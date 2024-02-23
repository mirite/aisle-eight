<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function submit(): void {
        $validated = $this->validate();
        auth()->user()->stores()->create($validated);
        $this->name = '';
    }
}; ?>

<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" wire:model="name" class="form-control" id="name" aria-describedby="nameHelp">
            <small id="nameHelp" class="form-text text-muted">Sort of like a story</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
