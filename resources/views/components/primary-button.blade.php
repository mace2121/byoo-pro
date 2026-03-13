<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-black dark:bg-white border border-transparent rounded-2xl font-black text-[10px] text-white dark:text-black uppercase tracking-widest hover:opacity-80 focus:outline-none transition ease-in-out duration-150 shadow-xl shadow-black/10 active:scale-95']) }}>
    {{ $slot }}
</button>
