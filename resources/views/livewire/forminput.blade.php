<?php

use function Livewire\Volt\{state};

//

?>

<x-form-group>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <input type="{{ $type ?? 'text' }}" id="{{ $id }}" wire:model="{{ $model }}"
        placeholder="{{ $placeholder }}"
        class="block w-full px-4 py-2 border-gray-300 text-slate-900 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
