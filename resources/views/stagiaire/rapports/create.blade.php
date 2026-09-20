@extends('layouts.app')
@section('title', 'Rédiger un Rapport')

@section('sidebar')
    <div class="px-2 mb-3">
        <p class="text-xs uppercase font-bold tracking-wider text-slate-400">Espace Stagiaire</p>
    </div>
    <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition">
        <i class="fa-solid fa-house text-indigo-400"></i> Mon Espace
    </a>
    <a href="{{ route('stagiaire.rapports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-indigo-600/30 text-white border border-indigo-500/30 text-sm font-semibold transition">
        <i class="fa-solid fa-file-signature text-cyan-400"></i> Mes Rapports
    </a>
    <a href="{{ route('stagiaire.geolocaliser') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition">
        <i class="fa-solid fa-location-crosshairs text-indigo-400"></i> Ma Localisation
    </a>
@endsection

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-pen-to-square text-cyan-400"></i> Rédiger un Rapport Périodique
            </h1>
            <p class="text-slate-400 text-sm mt-1">Résumez les activités réalisées et soumettez votre bilan à votre encadrant</p>
        </div>
        <a href="{{ route('stagiaire.rapports.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Annuler
        </a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('stagiaire.rapports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Période concernée *</label>
                    <select name="periode" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="Hebdomadaire" {{ old('periode') == 'Hebdomadaire' ? 'selected' : '' }}>Hebdomadaire (Semaine)</option>
                        <option value="Bimensuel" {{ old('periode') == 'Bimensuel' ? 'selected' : '' }}>Bimensuel (Quinzaine)</option>
                        <option value="Mensuel" {{ old('periode') == 'Mensuel' ? 'selected' : '' }}>Mensuel (Mois)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Titre du rapport *</label>
                    <input type="text" name="titre" value="{{ old('titre') }}" required placeholder="Ex: Rapport Semaine 3 - Travaux de laboratoire..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                    @error('titre')
                        <p class="text-rose-400 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Compte-rendu détaillé des activités *</label>
                <textarea name="contenu" rows="8" required placeholder="Décrivez les compétences acquises, les tâches accomplies et les éventuels blocages rencontrés..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 leading-relaxed">{{ old('contenu') }}</textarea>
                @error('contenu')
                    <p class="text-rose-400 text-xs mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Pièce jointe / Document PDF (Optionnel, Max 10 Mo)</label>
                <input type="file" name="fichier" accept=".pdf,.doc,.docx" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-300 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600/30 file:text-indigo-300 hover:file:bg-indigo-600/40 cursor-pointer">
                @error('fichier')
                    <p class="text-rose-400 text-xs mt-1.5 font-semibold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end gap-4">
                <a href="{{ route('stagiaire.rapports.index') }}" class="px-5 py-3 rounded-xl font-semibold border border-slate-700 text-slate-300 hover:bg-slate-800 text-sm transition">
                    Annuler
                </a>
                <button type="submit" class="gradient-bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:opacity-90 shadow-lg shadow-indigo-600/30 text-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Soumettre le Rapport
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
