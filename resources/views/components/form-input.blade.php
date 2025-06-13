<x-form-group>
				<x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
				<x-input-text id="{{ $id }}" wire:model="{{ $model }}" data-testid="{{ $testId ?? '' }}"
								type="{{ $type ?? 'text' }}" step="{{ $step ?? '' }}" />
				@if (isset($error))
								<x-input-error :messages="$error" class="mt-2" />
				@endif
</x-form-group>
