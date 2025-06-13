@php($classes = 'flex sm:flex-row flex-col gap-2')
<div {{ $attributes->merge(['class' => $classes]) }}>
				{{ $slot }}
</div>
