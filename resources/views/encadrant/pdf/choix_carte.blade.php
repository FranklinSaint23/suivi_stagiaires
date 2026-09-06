@extends('layouts.app')
@section('title', 'Générer Carte Stagiaire')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-800">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
            <i class="fa-solid fa-id-card text-amber-400"></i>
            <span>Générer une <span class="gradient-text">Carte Stagiaire</span></span>
        </h1>
        <p class="text-sm text-slate-400 mt-1">Sélectionnez un stagiaire pour éditer sa carte d'identification officielle</p>
    </div>

    <div class="glass-panel rounded-2xl p-6 sm:p-8 max-w-lg border border-slate-800 shadow-xl space-y-5">
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                Sélectionner le stagiaire
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <select id="sel" class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    <option value="" class="bg-slate-900 text-slate-400">-- Choisir un stagiaire --</option>
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}" class="bg-slate-900 text-slate-100">{{ $s->nom }} {{ $s->prenom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button onclick="if(document.getElementById('sel').value) window.location='/encadrant/pdf/carte/'+document.getElementById('sel').value"
                class="w-full gradient-bg-primary hover:opacity-95 text-white font-semibold py-3 px-5 rounded-xl shadow-lg shadow-indigo-600/30 transition text-sm flex items-center justify-center gap-2">
            <i class="fa-solid fa-download"></i>
            <span>Télécharger la Carte PDF</span>
        </button>
    </div>
</div>
@endsection

