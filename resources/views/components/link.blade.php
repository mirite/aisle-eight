@php
				$classes =
				    'font-semibold text-xl text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 focus:outline focus:outline-2 focus:rounded-xs focus:outline-red-500';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>{{ $slot }}</a>
