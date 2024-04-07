<?php

new class extends \Livewire\Volt\Component {
    public string $id;
    public string $label;
    public string $model;
    public string $placeholder;
    public \Illuminate\Database\Eloquent\Collection $children;
    public string $childLabelField;
    public array $error;

    public function mount(string $id, string $label, string $model, string $placeholder, \Illuminate\Database\Eloquent\Collection $children, string $childLabelField, array $error = []): void
    {
        $this->id = $id;
        $this->label = $label;
        $this->model = $model;
        $this->placeholder = $placeholder;
        $this->children = $children;
        $this->childLabelField = $childLabelField;
        $this->error = $error;
    }
};

?>

<x-form-group>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <x-input-select id="{{ $id }}" wire:model="{{ $model }}">
        <option value="">{{ $placeholder }}</option>
        @foreach ($children as $child)
            <option value="{{ $child->id }}">
                {{ is_callable($childLabelField) ? $childLabelField($child) : $child->$childLabelField }}</option>
        @endforeach
    </x-input-select>
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
