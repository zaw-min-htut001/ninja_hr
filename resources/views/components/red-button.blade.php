<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-800 border border-white-300 dark:border-white-500 rounded-md font-semibold text-xs text-white hover:text-white uppercase tracking-widest shadow-sm hover:bg-red-500 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-200 focus:ring-offset-2 dark:focus:ring-offset-red-200 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
