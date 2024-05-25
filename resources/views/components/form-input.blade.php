<x-form-group :attributes="$attributes">
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <x-input-text id="{{ $id }}" wire:model="{{ $model }}" type="{{ $type ?? 'text' }}"
        step="{{ $step ?? '' }}" />
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
