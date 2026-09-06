@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-2.5 text-slate-100 placeholder-slate-400 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm']) }}>
