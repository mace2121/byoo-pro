@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 dark:text-gray-300 focus:border-black dark:focus:border-white focus:ring-black dark:focus:ring-white rounded-2xl shadow-sm transition-all text-sm']) !!}>
