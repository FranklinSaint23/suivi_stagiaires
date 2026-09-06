<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 gradient-bg-primary text-white border border-transparent rounded-xl font-semibold text-xs uppercase tracking-widest hover:opacity-95 shadow-md shadow-indigo-600/30 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
