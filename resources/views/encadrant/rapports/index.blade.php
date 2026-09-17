@extends('layouts.app')
@section('title', 'Rapports Périodiques')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-file-signature text-cyan-400"></i> Rapports Périodiques Reçus
            </h1>
            <p class="text-slate-400 text-sm mt-1">Examinez, commentez et validez les rapports hebdomadaires / bimensuels</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="glass-panel p-4 rounded-2xl">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Filtrer par Stagiaire</label>
                <select name="stagiaire_id" onchange="this.form.submit()" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-sm">
                    <option value="">Tous les stagiaires</option>
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}" {{ request('stagiaire_id') == $s->id ? 'selected' : '' }}>{{ $s->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Statut</label>
                <select name="statut" onchange="this.form.submit()" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-slate-100 text-sm">
                    <option value="">Tous les statuts</option>
                    <option value="Soumis" {{ request('statut') == 'Soumis' ? 'selected' : '' }}>Soumis (À valider)</option>
                    <option value="Validé" {{ request('statut') == 'Validé' ? 'selected' : '' }}>Validé</option>
                    <option value="Correction demandée" {{ request('statut') == 'Correction demandée' ? 'selected' : '' }}>Correction demandée</option>
                </select>
            </div>
            <div class="flex items-end">
                <a href="{{ route('encadrant.rapports.index') }}" class="w-full bg-slate-800 hover:bg-slate-700 text-slate-300 text-center py-2 rounded-xl text-sm font-semibold transition border border-slate-700">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900/80 text-xs uppercase text-slate-400 font-bold border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-4">Stagiaire</th>
                        <th class="px-5 py-4">Titre & Période</th>
                        <th class="px-5 py-4">Date soumission</th>
                        <th class="px-5 py-4">Statut</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($rapports as $r)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="px-5 py-4 font-semibold text-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full gradient-bg-primary flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($r->stagiaire->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-100">{{ $r->stagiaire->nom_complet }}</p>
                                        <p class="text-xs text-slate-400">{{ $r->stagiaire->filiere }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-bold text-slate-100">{{ $r->titre }}</p>
                                <span class="text-xs font-mono text-indigo-300">{{ $r->periode }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs font-mono text-slate-400">
                                {{ $r->date_soumission->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $r->statut === 'Validé' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($r->statut === 'Correction demandée' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                                    {{ $r->statut }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('encadrant.rapports.show', $r) }}" class="gradient-bg-primary text-white text-xs font-semibold px-3.5 py-2 rounded-xl inline-flex items-center gap-1.5 shadow transition hover:opacity-90">
                                    <i class="fa-solid fa-eye"></i> Examiner & Valider
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-file-signature text-4xl text-slate-600 mb-3 block"></i>
                                Aucun rapport périodique trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
