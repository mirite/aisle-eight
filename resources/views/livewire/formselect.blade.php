<?php

use function Livewire\Volt\{state};

//

?>

<div class="form-group">
    <label for="{{$id}}">{{ $label }}</label>
    <select
        id="{{$id}}"
        wire:model="{{$model}}"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        <option value="">{{ $placeholder }}</option>
        @foreach ($children as $child)
            <option value="{{ $child->id }}">{{ is_callable($childLabelField) ? $childLabelField($child) : $child->$childLabelField }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$error" class="mt-2"/>
</div>
