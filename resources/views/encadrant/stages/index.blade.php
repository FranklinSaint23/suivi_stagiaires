@extends('layouts.app')
@section('title', 'Gestion des Stages')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-briefcase text-indigo-400"></i>
                <span>Gestion des <span class="gradient-text">Stages</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Attribution des thèmes, dates et suivi des établissements</p>
        </div>

        <a href="{{ route('encadrant.stages.create') }}"
           class="inline-flex items-center gap-2 gradient-bg-primary hover:opacity-95 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition">
            <i class="fa-solid fa-plus"></i>
            <span>Nouveau Stage</span>
        </a>
    </div>

    <!-- Filter Form -->
    <div class="glass-panel p-4 rounded-2xl border border-slate-800">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="theme" value="{{ request('theme') }}" placeholder="Thème de recherche..."
                       class="w-full px-3.5 py-2 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500">
            </div>

            <div class="min-w-[200px]">
                <select name="stagiaire_id" class="w-full px-3.5 py-2 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                    <option value="" class="bg-slate-900 text-slate-400">Tous les stagiaires</option>
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}" {{ request('stagiaire_id') == $s->id ? 'selected' : '' }} class="bg-slate-900 text-slate-100">
                            {{ $s->nom }} {{ $s->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-40">
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-3 py-2 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
            </div>

            <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-semibold px-4 py-2 rounded-xl text-sm transition flex items-center gap-1.5">
                <i class="fa-solid fa-filter"></i> Filtrer
            </button>
        </form>
    </div>

    <!-- Table Container -->
    <div class="glass-panel rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900/90 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3.5">Stagiaire</th>
                        <th class="px-4 py-3.5">Thème du stage</th>
                        <th class="px-4 py-3.5">Établissement</th>
                        <th class="px-4 py-3.5">Début</th>
                        <th class="px-4 py-3.5">Fin</th>
                        <th class="px-4 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300">
                    @forelse($stages as $stage)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 font-semibold text-white">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-800 border border-slate-700 text-indigo-400 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($stage->stagiaire?->nom ?? 'S', 0, 1)) }}
                                </div>
                                <span>{{ $stage->stagiaire?->nom }} {{ $stage->stagiaire?->prenom }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium text-indigo-300">{{ $stage->theme }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $stage->etablissement }}</td>
                        <td class="px-4 py-3 text-xs text-slate-400 font-mono">{{ $stage->date_debut->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-xs text-slate-400 font-mono">{{ $stage->date_fin->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('encadrant.stages.edit', $stage) }}"
                                   class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 px-2.5 py-1.5 rounded-lg text-xs font-semibold border border-amber-500/20 transition">
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </a>
                                <form action="{{ route('encadrant.stages.destroy', $stage) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Supprimer ce stage ?')">
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
                        <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-briefcase text-4xl mb-3 opacity-30 block"></i>
                            <p class="text-sm font-medium">Aucun stage enregistré.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

