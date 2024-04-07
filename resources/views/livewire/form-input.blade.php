<?php

use Livewire\Attributes\Modelable;

new class extends \Livewire\Volt\Component {
    public string $id;
    public string $label;

    #[Modelable]
    public string $value = '';

    public string $placeholder;
    public array $error;

    public function mount(string $id, string $label, string $placeholder, array $error = []): void
    {
        $this->id = $id;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->error = $error;
    }
};

?>

<x-form-group>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <x-input-text type="{{ $type ?? 'text' }}" id="{{ $id }}" wire:model="value"
        placeholder="{{ $placeholder }}" />
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
