@extends('layouts.app')
@section('title', 'Gestion des Encadrants')

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
                <i class="fa-solid fa-user-shield text-indigo-400"></i> Gestion des Encadrants
            </h1>
            <p class="text-slate-400 text-sm mt-1">Gérez les comptes d'accès et profils des encadrants de la plateforme</p>
        </div>
        <a href="{{ route('admin.encadrants.create') }}" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-lg shadow-indigo-600/30">
            <i class="fa-solid fa-user-plus"></i> Nouvel Encadrant
        </a>
    </div>

    <!-- WhatsApp Onboarding Notification Alert -->
    @if(session('whatsapp_link'))
        <div class="glass-panel p-5 rounded-2xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-300 space-y-3">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <p class="font-bold text-base flex items-center gap-2 text-emerald-200">
                        <i class="fa-brands fa-whatsapp text-2xl text-emerald-400"></i>
                        Compte Encadrant prêt pour {{ session('encadrant_nom', 'l\'encadrant') }} !
                    </p>
                    <p class="text-sm text-emerald-300/90">
                        Envoyez directement à l'encadrant son message de bienvenue avec ses identifiants de connexion (Matricule, Email, Mot de passe).
                    </p>
                </div>
                <a href="{{ session('whatsapp_link') }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow-lg shadow-emerald-600/30 transition shrink-0 animate-pulse">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Envoyer les identifiants sur WhatsApp
                </a>
            </div>
        </div>
    @endif

    <!-- Password Reset Notification Alert -->
    @if(session('reset_user'))
        <div class="glass-panel p-5 rounded-xl border border-amber-500/40 bg-amber-500/10 text-amber-300 text-sm space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-1">
                    <p class="font-bold flex items-center gap-2">
                        <i class="fa-solid fa-key"></i> Mot de passe réinitialisé pour {{ session('reset_user') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-400">Nouveau mot de passe temporaire :</span>
                        <span class="font-mono text-base font-bold bg-slate-900 px-3 py-1 rounded border border-slate-700 select-all text-amber-200">
                            {{ session('temp_password') }}
                        </span>
                    </div>
                </div>
                @if(session('whatsapp_link'))
                    <a href="{{ session('whatsapp_link') }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2 rounded-xl text-xs transition shrink-0">
                        <i class="fa-brands fa-whatsapp text-base"></i> Envoyer le nouveau pass via WhatsApp
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="glass-panel p-4 rounded-2xl">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom, email, téléphone ou matricule..." class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Encadrants Table -->
    <div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900/80 text-xs uppercase text-slate-400 font-bold border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-4">Nom & Prénom</th>
                        <th class="px-5 py-4">Matricule</th>
                        <th class="px-5 py-4">Contact & WhatsApp</th>
                        <th class="px-5 py-4">Stagiaires</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($encadrants as $enc)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="px-5 py-4 font-bold text-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full gradient-bg-primary flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($enc->nom, 0, 1)) }}
                                    </div>
                                    <span>{{ $enc->nom }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-indigo-300 font-semibold">{{ $enc->matricule }}</td>
                            <td class="px-5 py-4">
                                <div class="space-y-1">
                                    <div class="text-xs text-slate-300">{{ $enc->email }}</div>
                                    @if($enc->telephone)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-mono text-slate-400">{{ $enc->telephone }}</span>
                                            <a href="{{ \App\Helpers\WhatsAppHelper::messageLink($enc->telephone, "Bonjour {$enc->nom}, concernant votre compte encadrant sur StageTrack...") }}" 
                                               target="_blank" rel="noopener noreferrer"
                                               title="Contacter sur WhatsApp"
                                               class="inline-flex items-center gap-1 text-[11px] bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 px-2 py-0.5 rounded border border-emerald-500/30 transition">
                                                <i class="fa-brands fa-whatsapp"></i> Chat
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-[11px] text-slate-500 italic">Pas de numéro</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $enc->stagiaires->count() }} stagiaire(s)
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <form action="{{ route('admin.encadrants.reset_password', $enc) }}" method="POST" class="inline-block" onsubmit="return confirm('Réinitialiser le mot de passe de cet encadrant ?')">
                                    @csrf
                                    <button class="bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 border border-amber-500/30 px-3 py-1.5 rounded-lg text-xs font-medium transition" title="Réinitialiser le mot de passe">
                                        <i class="fa-solid fa-key"></i> Reset
                                    </button>
                                </form>
                                <a href="{{ route('admin.encadrants.edit', $enc) }}" class="bg-slate-800 text-slate-200 hover:bg-slate-700 border border-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium transition inline-block">
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </a>
                                <form action="{{ route('admin.encadrants.destroy', $enc) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer définitivement cet encadrant ?')">
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
                                <i class="fa-solid fa-user-shield text-4xl text-slate-600 mb-3 block"></i>
                                Aucun encadrant trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
