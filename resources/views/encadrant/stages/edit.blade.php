@extends('layouts.app')
@section('title', 'Modifier le stage')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6 max-w-3xl">
    <div>
        <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
            <i class="fa-solid fa-pen-to-square text-indigo-400"></i> Modifier le Stage
        </h1>
        <p class="text-slate-400 text-sm mt-1">Mettez à jour les informations et documents du stage</p>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-2xl">
        <form action="{{ route('encadrant.stages.update', $stage) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Stagiaire</label>
                    <select name="stagiaire_id" required class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        @foreach($stagiaires as $s)
                            <option value="{{ $s->id }}" {{ $stage->stagiaire_id == $s->id ? 'selected' : '' }}>
                                {{ $s->nom }} {{ $s->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Date de début</label>
                        <input type="date" name="date_debut" value="{{ $stage->date_debut->format('Y-m-d') }}" required class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Date de fin</label>
                        <input type="date" name="date_fin" value="{{ $stage->date_fin->format('Y-m-d') }}" required class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Établissement / Lieu</label>
                    <input type="text" name="etablissement" value="{{ $stage->etablissement }}" required class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Thème de stage</label>
                    <input type="text" name="theme" value="{{ $stage->theme }}" required class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Rapport (PDF) — remplacer</label>
                        <input type="file" name="rapport" accept=".pdf" class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-2.5 text-slate-300 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600/30 file:text-indigo-300 hover:file:bg-indigo-600/40">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Convention (PDF) — remplacer</label>
                        <input type="file" name="convention" accept=".pdf" class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl px-4 py-2.5 text-slate-300 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600/30 file:text-indigo-300 hover:file:bg-indigo-600/40">
                    </div>
                </div>
            </div>
            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="gradient-bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:opacity-95 shadow-lg shadow-indigo-500/25 text-sm transition">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Mettre à jour
                </button>
                <a href="{{ route('encadrant.stages.index') }}" class="px-5 py-3 rounded-xl font-semibold border border-slate-700 text-slate-300 hover:bg-slate-800 text-sm transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
