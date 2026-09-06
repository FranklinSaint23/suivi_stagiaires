@extends('layouts.app')
@section('title', 'Liste des Stagiaires')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-users text-indigo-400"></i>
                <span>Gestion des <span class="gradient-text">Stagiaires</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Liste complète des stagiaires enregistrés et suivi individuel</p>
        </div>

        <a href="{{ route('encadrant.stagiaires.create') }}"
           class="inline-flex items-center gap-2 gradient-bg-primary hover:opacity-95 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition">
            <i class="fa-solid fa-user-plus"></i>
            <span>Nouveau Stagiaire</span>
        </a>
    </div>

    <!-- Filter Form -->
    <div class="glass-panel p-4 rounded-2xl border border-slate-800">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[240px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom ou prénom..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition">
                Rechercher
            </button>
            @if($search)
                <a href="{{ route('encadrant.stagiaires.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium transition">
                    Réinitialiser
                </a>
            @endif
        </form>
    </div>

    <!-- Table Container -->
    <div class="glass-panel rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900/90 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3.5">Stagiaire</th>
                        <th class="px-4 py-3.5">Email</th>
                        <th class="px-4 py-3.5">Filière</th>
                        <th class="px-4 py-3.5">Lieu</th>
                        <th class="px-4 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300">
                    @forelse($stagiaires as $s)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 font-semibold text-white">
                            <div class="flex items-center gap-3">
                                @if($s->photo)
                                    <img src="{{ route('fichier', ['path' => $s->photo]) }}" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($s->nom, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-slate-100">{{ $s->nom }} {{ $s->prenom }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $s->email }}</td>
                        <td class="px-4 py-3 text-slate-300 font-medium">{{ $s->filiere }}</td>
                        <td class="px-4 py-3 text-slate-400">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-slate-500 text-xs"></i> {{ $s->lieu }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('encadrant.stagiaires.show', $s) }}"
                                   class="inline-flex items-center gap-1 bg-slate-800 hover:bg-slate-700 text-slate-200 px-2.5 py-1.5 rounded-lg text-xs font-medium border border-slate-700 transition">
                                    <i class="fa-solid fa-id-badge"></i> Profil
                                </a>
                                <a href="{{ route('encadrant.stagiaires.edit', $s) }}"
                                   class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 px-2.5 py-1.5 rounded-lg text-xs font-semibold border border-amber-500/20 transition">
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </a>
                                <form action="{{ route('encadrant.stagiaires.destroy', $s) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Supprimer ce stagiaire ?')">
                                    @csrf @method('DELETE')
                                    <button class="inline-flex items-center gap-1 bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 px-2.5 py-1.5 rounded-lg text-xs font-semibold border border-rose-500/20 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3 opacity-30 block"></i>
                            <p class="text-sm font-medium">Aucun stagiaire trouvé.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

