<input
    {{ $attributes->merge(['class' => ' px-4 py-2 border-gray-300 text-slate-900 dark:text-white focus:border-indigo-300 focus:ring-3 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-xs ' . ($type !== 'checkbox' ? 'w-full' : 'mr-auto')]) }}>
