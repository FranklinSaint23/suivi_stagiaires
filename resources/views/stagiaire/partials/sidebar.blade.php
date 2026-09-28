<div class="px-3 py-2 mb-2">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Espace Stagiaire</p>
</div>
<div class="space-y-1 font-medium text-sm">
    <a href="{{ route('stagiaire.dashboard') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/70 hover:text-slate-900 dark:hover:text-white' }}">
        <i class="fa-solid fa-house w-5 text-center text-base {{ request()->routeIs('stagiaire.dashboard') ? 'text-white' : 'text-indigo-600 dark:text-indigo-400' }}"></i>
        <span>Mon Espace</span>
    </a>
    <a href="{{ route('stagiaire.rapports.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.rapports.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/70 hover:text-slate-900 dark:hover:text-white' }}">
        <i class="fa-solid fa-file-signature w-5 text-center text-base {{ request()->routeIs('stagiaire.rapports.*') ? 'text-white' : 'text-cyan-600 dark:text-cyan-400' }}"></i>
        <span>Mes Rapports</span>
    </a>
    <a href="{{ route('stagiaire.pdf.presences') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.pdf.presences') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/70 hover:text-slate-900 dark:hover:text-white' }}">
        <i class="fa-solid fa-file-pdf w-5 text-center text-base {{ request()->routeIs('stagiaire.pdf.presences') ? 'text-white' : 'text-rose-600 dark:text-rose-400' }}"></i>
        <span>Mes présences PDF</span>
    </a>
    <a href="{{ route('stagiaire.geolocaliser') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('stagiaire.geolocaliser') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/70 hover:text-slate-900 dark:hover:text-white' }}">
        <i class="fa-solid fa-location-dot w-5 text-center text-base {{ request()->routeIs('stagiaire.geolocaliser') ? 'text-white' : 'text-emerald-600 dark:text-emerald-400' }}"></i>
        <span>Ma Localisation</span>
    </a>
</div>
