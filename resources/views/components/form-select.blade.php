<x-form-group>
    <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    <x-input-select id="{{ $id }}" wire:model="{{ $model }}">
        <option value="">{{ $placeholder ?? '' }}</option>
        @foreach ($children as $child)
            <option value="{{ $child->id ?? $child }}">
                @if (isset($childLabelField))
                    {{ is_callable($childLabelField) ? $childLabelField($child) : $child->$childLabelField }}
                @else
                    {{ $child }}
                @endif
            </option>
        @endforeach
    </x-input-select>
    <x-input-error :messages="$error" class="mt-2" />
</x-form-group>
