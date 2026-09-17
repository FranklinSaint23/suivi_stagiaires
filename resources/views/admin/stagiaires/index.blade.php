@extends('layouts.app')
@section('title', 'Gestion des Stagiaires')

@section('sidebar')
<div class="px-3 py-2 mb-2">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Administration</p>
</div>
<div class="space-y-1 font-medium text-sm">
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-chart-line w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Tableau de bord</span>
    </a>
    <a href="{{ route('admin.users.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-users-gear w-5 text-center text-base {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-purple-400' }}"></i>
        <span>Tous les Comptes</span>
    </a>
    <a href="{{ route('admin.encadrants.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.encadrants.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-user-shield w-5 text-center text-base {{ request()->routeIs('admin.encadrants.*') ? 'text-white' : 'text-amber-400' }}"></i>
        <span>Gestion Encadrants</span>
    </a>
    <a href="{{ route('admin.stagiaires.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.stagiaires.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-user-graduate w-5 text-center text-base {{ request()->routeIs('admin.stagiaires.*') ? 'text-white' : 'text-emerald-400' }}"></i>
        <span>Gestion Stagiaires</span>
    </a>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-user-graduate text-indigo-400"></i> Gestion des Stagiaires
            </h1>
            <p class="text-slate-400 text-sm mt-1">Gérez les comptes, profils et informations des stagiaires de l'établissement</p>
        </div>
        <a href="{{ route('admin.stagiaires.create') }}" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-lg shadow-indigo-600/30">
            <i class="fa-solid fa-user-plus"></i> Nouveau Stagiaire
        </a>
    </div>

    <!-- Password Reset Notification Alert -->
    @if(session('reset_user'))
        <div class="glass-panel p-4 rounded-xl border border-amber-500/40 bg-amber-500/10 text-amber-300 text-sm space-y-1">
            <p class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-key"></i> Mot de passe réinitialisé pour {{ session('reset_user') }}
            </p>
            <p class="font-mono text-base font-bold bg-slate-900 inline-block px-3 py-1 rounded border border-slate-700 select-all">
                {{ session('temp_password') }}
            </p>
            <p class="text-xs text-slate-400">Transmettez ce mot de passe temporaire au stagiaire.</p>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="glass-panel p-4 rounded-2xl">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom, prénom, email ou filière..." class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Stagiaires Table -->
    <div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900/80 text-xs uppercase text-slate-400 font-bold border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-4">Stagiaire</th>
                        <th class="px-5 py-4">Filière / Lieu</th>
                        <th class="px-5 py-4">Contact</th>
                        <th class="px-5 py-4">Genre</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($stagiaires as $stg)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="px-5 py-4 font-bold text-slate-100">
                                <div class="flex items-center gap-3">
                                    @if($stg->photo)
                                        <img src="{{ asset('storage/' . $stg->photo) }}" alt="Photo" class="w-10 h-10 rounded-full object-cover border border-indigo-500/30">
                                    @else
                                        <div class="w-10 h-10 rounded-full gradient-bg-primary flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($stg->prenom, 0, 1) . substr($stg->nom, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-100">{{ $stg->nom_complet }}</p>
                                        <p class="text-xs text-slate-400 font-normal">{{ $stg->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-xs">
                                <span class="font-semibold text-indigo-300 block">{{ $stg->filiere ?? 'N/A' }}</span>
                                <span class="text-slate-400">{{ $stg->lieu ?? 'N/A' }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-300 text-xs font-mono">
                                {{ $stg->telephone ?? 'Non renseigné' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $stg->sexe == 'M' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-pink-500/20 text-pink-300 border border-pink-500/30' }}">
                                    {{ $stg->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <form action="{{ route('admin.stagiaires.reset_password', $stg) }}" method="POST" class="inline-block" onsubmit="return confirm('Réinitialiser le mot de passe de ce stagiaire ?')">
                                    @csrf
                                    <button class="bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 border border-amber-500/30 px-3 py-1.5 rounded-lg text-xs font-medium transition" title="Réinitialiser le mot de passe">
                                        <i class="fa-solid fa-key"></i> Reset
                                    </button>
                                </form>
                                <a href="{{ route('admin.stagiaires.edit', $stg) }}" class="bg-slate-800 text-slate-200 hover:bg-slate-700 border border-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium transition inline-block">
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </a>
                                <form action="{{ route('admin.stagiaires.destroy', $stg) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer définitivement ce stagiaire ?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-user-graduate text-4xl text-slate-600 mb-3 block"></i>
                                Aucun stagiaire trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
