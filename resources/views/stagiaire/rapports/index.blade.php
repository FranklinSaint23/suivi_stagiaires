@extends('layouts.app')
@section('title', 'Mes Rapports Périodiques')

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
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-file-signature text-cyan-400"></i> Mes Rapports Périodiques
            </h1>
            <p class="text-slate-400 text-sm mt-1">Consultez l'historique de vos soumissions et les retours de votre encadrant</p>
        </div>
        <a href="{{ route('stagiaire.rapports.create') }}" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2 shadow-lg shadow-indigo-600/30">
            <i class="fa-solid fa-pen-to-square"></i> Rédiger un Rapport
        </a>
    </div>

    <!-- Reports Cards List -->
    <div class="space-y-4">
        @forelse($rapports as $r)
            <div class="glass-panel p-6 rounded-2xl border border-slate-800 space-y-4">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 border-b border-slate-700/60 pb-3">
                    <div>
                        <span class="text-xs font-mono text-indigo-400 uppercase tracking-wider font-bold">{{ $r->periode }}</span>
                        <h2 class="text-lg font-bold text-slate-100 mt-0.5">{{ $r->titre }}</h2>
                        <p class="text-xs text-slate-400">Soumis le {{ $r->date_soumission->format('d/m/Y à H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold self-start sm:self-auto {{ $r->statut === 'Validé' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($r->statut === 'Correction demandée' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                        {{ $r->statut }}
                    </span>
                </div>

                <div class="text-sm text-slate-300 line-clamp-3 bg-slate-900/60 p-3.5 rounded-xl border border-slate-800/80 leading-relaxed">
                    {{ $r->contenu }}
                </div>

                @if($r->fichier)
                    <div class="pt-1">
                        <a href="{{ route('fichier', ['path' => $r->fichier]) }}" target="_blank" class="inline-flex items-center gap-2 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-semibold px-3.5 py-2 rounded-xl transition">
                            <i class="fa-solid fa-file-pdf text-rose-400 text-sm"></i> Consulter le document joint
                        </a>
                    </div>
                @endif

                @if($r->commentaire_encadrant)
                    <div class="bg-indigo-500/10 border border-indigo-500/30 p-4 rounded-xl space-y-1">
                        <p class="text-xs font-bold text-indigo-300 flex items-center gap-2">
                            <i class="fa-solid fa-comment-dots"></i> Remarques de l'Encadrant :
                        </p>
                        <p class="text-sm text-slate-200 leading-relaxed">{{ $r->commentaire_encadrant }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="glass-panel p-8 rounded-2xl text-center text-slate-400 py-12">
                <i class="fa-solid fa-file-signature text-4xl text-slate-600 mb-3 block"></i>
                <p class="mb-4">Vous n'avez encore soumis aucun rapport périodique.</p>
                <a href="{{ route('stagiaire.rapports.create') }}" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Rédiger mon premier rapport
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
