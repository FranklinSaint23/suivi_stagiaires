<div class="px-3 py-2 mb-2">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Espace Encadrant</p>
</div>

<div class="space-y-1 font-medium text-sm">
    <a href="{{ route('encadrant.dashboard') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-chart-pie w-5 text-center text-base {{ request()->routeIs('encadrant.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Tableau de bord</span>
    </a>

    <a href="{{ route('encadrant.stagiaires.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.stagiaires.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-users w-5 text-center text-base {{ request()->routeIs('encadrant.stagiaires.*') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Stagiaires</span>
    </a>

    <a href="{{ route('encadrant.stages.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.stages.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-briefcase w-5 text-center text-base {{ request()->routeIs('encadrant.stages.*') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Gestion des Stages</span>
    </a>

    <a href="{{ route('encadrant.demandes.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.demandes.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-inbox w-5 text-center text-base {{ request()->routeIs('encadrant.demandes.*') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Demandes reçues</span>
    </a>

    <div class="pt-4 pb-1 px-3">
        <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Présences & Suivi</p>
    </div>

    <a href="{{ route('encadrant.presences.create') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.presences.create') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-calendar-check w-5 text-center text-base {{ request()->routeIs('encadrant.presences.create') ? 'text-white' : 'text-emerald-400' }}"></i>
        <span>Pointer présence</span>
    </a>

    <a href="{{ route('encadrant.presences.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.presences.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-calendar-days w-5 text-center text-base {{ request()->routeIs('encadrant.presences.index') ? 'text-white' : 'text-emerald-400' }}"></i>
        <span>Récap Présences</span>
    </a>

    <a href="{{ route('encadrant.messages.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.messages.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-comments w-5 text-center text-base {{ request()->routeIs('encadrant.messages.*') ? 'text-white' : 'text-purple-400' }}"></i>
        <span>Messages</span>
    </a>

    <div class="pt-4 pb-1 px-3">
        <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Outils & Exports</p>
    </div>

    <a href="{{ route('encadrant.pdf.choix_attestation') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.pdf.choix_attestation') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-file-pdf w-5 text-center text-base {{ request()->routeIs('encadrant.pdf.choix_attestation') ? 'text-white' : 'text-rose-400' }}"></i>
        <span>Attestation PDF</span>
    </a>

    <a href="{{ route('encadrant.pdf.choix_carte') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.pdf.choix_carte') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-id-card w-5 text-center text-base {{ request()->routeIs('encadrant.pdf.choix_carte') ? 'text-white' : 'text-amber-400' }}"></i>
        <span>Carte Stagiaire</span>
    </a>

    <a href="{{ route('encadrant.pdf.presences') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.pdf.presences') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-file-export w-5 text-center text-base {{ request()->routeIs('encadrant.pdf.presences') ? 'text-white' : 'text-rose-400' }}"></i>
        <span>Export Présences PDF</span>
    </a>

    <a href="{{ route('encadrant.carte_interactive') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('encadrant.carte_interactive') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-map-location-dot w-5 text-center text-base {{ request()->routeIs('encadrant.carte_interactive') ? 'text-white' : 'text-cyan-400' }}"></i>
        <span>Carte Interactive</span>
    </a>
</div>

