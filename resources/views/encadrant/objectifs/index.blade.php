@extends('layouts.app')
@section('title', 'Gestion des Objectifs')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-bullseye text-amber-400"></i> Objectifs des Stagiaires
            </h1>
            <p class="text-slate-400 text-sm mt-1">Assignez et suivez l'avancement des objectifs de stage</p>
        </div>
        <button onclick="document.getElementById('modalAddObjectif').classList.remove('hidden')" 
                class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-lg shadow-indigo-600/30">
            <i class="fa-solid fa-plus"></i> Nouvel Objectif
        </button>
    </div>

    <!-- Filter Form -->
    <div class="glass-panel p-4 rounded-2xl">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Filtrer par Stagiaire</label>
                <select name="stagiaire_id" onchange="this.form.submit()" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-sm">
                    <option value="">Tous les stagiaires</option>
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}" {{ request('stagiaire_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->nom_complet }} ({{ $s->filiere }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Statut</label>
                <select name="statut" onchange="this.form.submit()" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-sm">
                    <option value="">Tous les statuts</option>
                    <option value="À faire" {{ request('statut') == 'À faire' ? 'selected' : '' }}>À faire</option>
                    <option value="En cours" {{ request('statut') == 'En cours' ? 'selected' : '' }}>En cours</option>
                    <option value="Terminé" {{ request('statut') == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                </select>
            </div>
            <div class="flex items-end">
                <a href="{{ route('encadrant.objectifs.index') }}" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-300 text-center py-2 rounded-xl text-sm font-semibold transition border border-slate-700">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Objectives Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($objectifs as $obj)
            <div class="glass-panel p-5 rounded-2xl space-y-3 relative border border-slate-800 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="flex justify-between items-start">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $obj->statut === 'Terminé' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($obj->statut === 'En cours' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-slate-700/50 text-slate-300 border border-slate-600') }}">
                            {{ $obj->statut }}
                        </span>
                        <form action="{{ route('encadrant.objectifs.destroy', $obj) }}" method="POST" onsubmit="return confirm('Supprimer cet objectif ?')">
                            @csrf @method('DELETE')
                            <button class="text-slate-500 hover:text-rose-400 transition text-sm">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    <h3 class="font-bold text-slate-100 text-base leading-snug">{{ $obj->titre }}</h3>
                    @if($obj->description)
                        <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $obj->description }}</p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-800/80 space-y-1.5 text-xs text-slate-400">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-slate-300">Stagiaire :</span>
                        <span class="text-indigo-400 font-semibold">{{ $obj->stagiaire->nom_complet }}</span>
                    </div>
                    @if($obj->date_limite)
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-300">Date limite :</span>
                            <span class="font-mono text-slate-300">{{ $obj->date_limite->format('d/m/Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full glass-panel p-8 rounded-2xl text-center text-slate-400 py-12">
                <i class="fa-solid fa-bullseye text-4xl text-slate-600 mb-3 block"></i>
                <p>Aucun objectif enregistré pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Creation Objectif -->
<div id="modalAddObjectif" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="glass-panel border border-slate-700/80 rounded-2xl shadow-2xl p-6 w-full max-w-md space-y-5">
        <div class="flex items-center justify-between border-b border-slate-700/60 pb-3">
            <h2 class="text-lg font-bold text-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-amber-400"></i> Assigner un Objectif
            </h2>
            <button type="button" onclick="document.getElementById('modalAddObjectif').classList.add('hidden')" class="text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('encadrant.objectifs.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-1">Stagiaire destinataire *</label>
                <select name="stagiaire_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Sélectionner un stagiaire...</option>
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}">{{ $s->nom_complet }} ({{ $s->filiere }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-1">Titre de l'objectif *</label>
                <input type="text" name="titre" required placeholder="Ex: Rédaction du chapitre 1 du rapport..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-1">Description / Consignes</label>
                <textarea name="description" rows="3" placeholder="Précisez les attentes..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-1">Date limite de réalisation</label>
                <input type="date" name="date_limite" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-800">
                <button type="button" onclick="document.getElementById('modalAddObjectif').classList.add('hidden')" class="px-4 py-2.5 rounded-xl text-slate-300 border border-slate-700 hover:bg-slate-800 text-sm font-semibold">
                    Annuler
                </button>
                <button type="submit" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 shadow-lg">
                    Assigner l'Objectif
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
