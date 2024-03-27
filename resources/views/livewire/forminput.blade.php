<?php

use function Livewire\Volt\{state};

//

?>

<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input type="{{ $type ?? 'text' }}" id="{{ $id }}" wire:model="{{ $model }}"
        placeholder="{{ $placeholder }}"
        class="block w-full border-gray-300 text-slate-900 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
    <x-input-error :messages="$error" class="mt-2" />
</div>
