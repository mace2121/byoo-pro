<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white dark:bg-black border border-gray-100 dark:border-gray-800 rounded-2xl font-black text-[10px] text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-900 focus:outline-none transition ease-in-out duration-150 active:scale-95']) }}>
    {{ $slot }}
</button>
