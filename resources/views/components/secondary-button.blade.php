<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl font-semibold text-xs text-slate-300 uppercase tracking-widest shadow-sm hover:bg-slate-700 hover:text-white transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
