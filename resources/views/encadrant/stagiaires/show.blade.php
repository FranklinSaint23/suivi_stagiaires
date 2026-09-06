@extends('layouts.app')
@section('title', 'Profil stagiaire')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="glass-panel p-6 rounded-2xl flex flex-col sm:flex-row items-center gap-6">
        @if($stagiaire->photo)
            <img src="{{ route('fichier', ['path' => $stagiaire->photo]) }}" class="w-24 h-24 rounded-full object-cover ring-4 ring-indigo-500/30 shadow-xl">
        @else
            <div class="w-24 h-24 rounded-full gradient-bg-primary flex items-center justify-center text-white text-3xl font-extrabold shadow-xl ring-4 ring-indigo-500/30">
                {{ strtoupper(substr($stagiaire->nom, 0, 1)) }}
            </div>
        @endif
        <div class="text-center sm:text-left space-y-1">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-100">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h1>
            <p class="text-indigo-400 font-medium text-sm flex items-center justify-center sm:justify-start gap-2">
                <i class="fa-solid fa-graduation-cap"></i> {{ $stagiaire->filiere }} <span class="text-slate-600">•</span> <i class="fa-solid fa-location-dot"></i> {{ $stagiaire->lieu }}
            </p>
            <p class="text-slate-400 text-xs flex items-center justify-center sm:justify-start gap-2">
                <i class="fa-solid fa-envelope"></i> {{ $stagiaire->email }}
            </p>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Info -->
        <div class="glass-panel p-6 rounded-2xl space-y-4">
            <h2 class="text-lg font-bold text-slate-100 flex items-center gap-2 border-b border-slate-700/60 pb-3">
                <i class="fa-solid fa-user-gear text-indigo-400"></i> Informations Personnelles
            </h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between py-1 border-b border-slate-800/60">
                    <dt class="text-slate-400 font-medium">Sexe</dt>
                    <dd class="text-slate-200 font-semibold">{{ $stagiaire->sexe }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/60">
                    <dt class="text-slate-400 font-medium">Date de Naissance</dt>
                    <dd class="text-slate-200 font-semibold">{{ $stagiaire->naissance?->format('d/m/Y') ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/60">
                    <dt class="text-slate-400 font-medium">Lieu de Naissance</dt>
                    <dd class="text-slate-200 font-semibold">{{ $stagiaire->lieu_naissance ?? '-' }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800/60">
                    <dt class="text-slate-400 font-medium">Téléphone</dt>
                    <dd class="text-slate-200 font-semibold">{{ $stagiaire->telephone }}</dd>
                </div>
                <div class="flex justify-between py-1">
                    <dt class="text-slate-400 font-medium">Taux de Présence</dt>
                    <dd>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $stagiaire->taux_presence >= 75 ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }}">
                            {{ $stagiaire->taux_presence }}%
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Stages -->
        <div class="glass-panel p-6 rounded-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-slate-700/60 pb-3">
                <h2 class="text-lg font-bold text-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-indigo-400"></i> Stages enregistrés
                </h2>
                <a href="{{ route('encadrant.stages.create', ['stagiaire_id' => $stagiaire->id]) }}"
                   class="text-xs gradient-bg-primary text-white px-3 py-1.5 rounded-lg font-semibold hover:opacity-90 transition">
                    <i class="fa-solid fa-plus mr-1"></i> Ajouter
                </a>
            </div>
            @forelse($stagiaire->stages as $stage)
                <div class="glass-card p-4 rounded-xl space-y-2 border border-slate-800">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-slate-100 text-sm">{{ $stage->theme }}</p>
                            <p class="text-xs text-indigo-300">{{ $stage->etablissement }}</p>
                        </div>
                        <span class="text-xs text-slate-400 font-mono">
                            {{ $stage->date_debut->format('d/m/Y') }} → {{ $stage->date_fin->format('d/m/Y') }}
                        </span>
                    </div>
                    <div class="flex gap-2 pt-2 border-t border-slate-800">
                        <a href="{{ route('encadrant.stages.edit', $stage) }}"
                           class="text-xs bg-amber-500/20 text-amber-300 border border-amber-500/30 px-2.5 py-1 rounded-lg font-medium hover:bg-amber-500/30 transition">
                            <i class="fa-solid fa-pen mr-1"></i> Modifier
                        </a>
                        <form action="{{ route('encadrant.stages.destroy', $stage) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce stage ?')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-rose-500/20 text-rose-300 border border-rose-500/30 px-2.5 py-1 rounded-lg font-medium hover:bg-rose-500/30 transition">
                                <i class="fa-solid fa-trash mr-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm italic py-4 text-center">Aucun stage enregistré.</p>
            @endforelse
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex flex-wrap items-center gap-3 glass-panel p-4 rounded-2xl">
        <a href="{{ route('encadrant.pdf.attestation', $stagiaire) }}"
           class="gradient-bg-primary text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-file-pdf"></i> Attestation PDF
        </a>
        <a href="{{ route('encadrant.pdf.carte', $stagiaire) }}"
           class="bg-purple-600 hover:bg-purple-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-id-card"></i> Carte PDF
        </a>
        <a href="{{ route('encadrant.stagiaires.edit', $stagiaire) }}"
           class="bg-amber-600 hover:bg-amber-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-user-pen"></i> Modifier
        </a>
        <button onclick="genererRapport()" id="btn-rapport"
                class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center gap-2">
            <i class="fa-solid fa-wand-magic-sparkles"></i> <span id="btn-rapport-text">Rapport IA</span>
        </button>
        <a href="{{ route('encadrant.stagiaires.index') }}"
           class="ml-auto bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

    <!-- AI Report Result Box -->
    <div id="ai-rapport-box" class="hidden glass-panel border border-indigo-500/30 rounded-2xl p-6 space-y-4">
        <div class="flex justify-between items-center border-b border-indigo-500/20 pb-3">
            <h3 class="font-bold text-indigo-300 text-lg flex items-center gap-2">
                <i class="fa-solid fa-robot"></i> Rapport de performance IA
            </h3>
            <button onclick="window.print()" class="text-xs bg-indigo-600/30 text-indigo-300 hover:bg-indigo-600/50 px-3 py-1.5 rounded-lg border border-indigo-500/30 font-medium transition">
                <i class="fa-solid fa-print mr-1"></i> Imprimer
            </button>
        </div>
        <div id="ai-rapport-text" class="text-sm text-slate-200 leading-relaxed whitespace-pre-line bg-slate-900/60 p-4 rounded-xl border border-slate-800"></div>
    </div>
    <div id="ai-rapport-error" class="hidden glass-panel border border-rose-500/40 text-rose-300 rounded-2xl p-5 text-sm"></div>
</div>
@endsection

@push('scripts')
<script>
async function genererRapport() {
    const btn = document.getElementById('btn-rapport');
    const txt = document.getElementById('btn-rapport-text');
    const box = document.getElementById('ai-rapport-box');
    const err = document.getElementById('ai-rapport-error');

    btn.disabled = true;
    txt.textContent = 'Génération…';
    box.classList.add('hidden');
    err.classList.add('hidden');

    try {
        const r = await fetch('{{ route('encadrant.ai.rapport', $stagiaire) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await r.json();
        if (data.result) {
            document.getElementById('ai-rapport-text').textContent = data.result;
            box.classList.remove('hidden');
        } else {
            err.textContent = '⚠️ ' + (data.error ?? 'Erreur inconnue');
            err.classList.remove('hidden');
        }
    } catch(e) {
        err.textContent = '⚠️ Erreur de connexion.';
        err.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        txt.textContent = 'Rapport IA';
    }
}
</script>
@endpush
