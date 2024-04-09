<x-form-group>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <x-input-text type="{{ $type ?? 'text' }}" id="{{ $id }}" wire:model="{{ $model }}"
        placeholder="{{ $placeholder }}" />
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
