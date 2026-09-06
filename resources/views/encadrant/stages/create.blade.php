@extends('layouts.app')
@section('title', 'Ajouter un Stage')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-800">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
            <i class="fa-solid fa-briefcase text-indigo-400"></i>
            <span>Ajouter un <span class="gradient-text">Stage</span></span>
        </h1>
        <p class="text-sm text-slate-400 mt-1">Créez un nouveau dossier de stage et affectez un thème</p>
    </div>

    <div class="glass-panel rounded-2xl p-6 sm:p-8 max-w-xl border border-slate-800 shadow-xl">
        <form action="{{ route('encadrant.stages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Stagiaire *</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-user-graduate text-sm"></i>
                    </div>
                    <select name="stagiaire_id" required class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="" class="bg-slate-900 text-slate-400">-- Choisir un stagiaire --</option>
                        @foreach($stagiaires as $s)
                            <option value="{{ $s->id }}" {{ request('stagiaire_id') == $s->id ? 'selected' : '' }} class="bg-slate-900 text-slate-100">
                                {{ $s->nom }} {{ $s->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Date début *</label>
                    <input type="date" name="date_debut" required class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Date fin *</label>
                    <input type="date" name="date_fin" required class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Établissement *</label>
                <input type="text" name="etablissement" required placeholder="Ex: Hôpital Régional de Yaoundé"
                       class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Thème du stage *</label>
                <input type="text" name="theme" required placeholder="Sujet de recherche ou mission"
                       class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm placeholder-slate-500 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Rapport de stage (PDF)</label>
                <input type="file" name="rapport" accept=".pdf" 
                       class="w-full bg-slate-900 border border-slate-700/80 rounded-xl p-2 text-xs text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Convention de stage (PDF)</label>
                <input type="file" name="convention" accept=".pdf" 
                       class="w-full bg-slate-900 border border-slate-700/80 rounded-xl p-2 text-xs text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="pt-3 flex items-center gap-3">
                <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-semibold py-3 px-5 rounded-xl shadow-lg shadow-indigo-600/30 transition text-sm flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Enregistrer</span>
                </button>
                <a href="{{ route('encadrant.stages.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-5 py-3 rounded-xl text-sm font-medium transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

