<?php

use function Livewire\Volt\{state};

//

?>

<x-form-group>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <select id="{{ $id }}" wire:model="{{ $model }}"
        class="block w-full px-4 py-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <option value="">{{ $placeholder }}</option>
        @foreach ($children as $child)
            <option value="{{ $child->id }}">
                {{ is_callable($childLabelField) ? $childLabelField($child) : $child->$childLabelField }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
