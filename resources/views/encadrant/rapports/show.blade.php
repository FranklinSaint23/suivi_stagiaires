@extends('layouts.app')
@section('title', 'Examen du Rapport')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-file-signature text-cyan-400"></i> Examen du Rapport Périodique
            </h1>
            <p class="text-slate-400 text-sm mt-1">Soumis par {{ $rapport->stagiaire->nom_complet }} ({{ $rapport->stagiaire->filiere }})</p>
        </div>
        <a href="{{ route('encadrant.rapports.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Report Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-panel p-6 rounded-2xl space-y-4 border border-slate-800">
                <div class="flex justify-between items-start border-b border-slate-700/60 pb-4">
                    <div>
                        <span class="text-xs font-mono text-indigo-400 uppercase tracking-wider font-bold">{{ $rapport->periode }}</span>
                        <h2 class="text-xl font-bold text-slate-100 mt-1">{{ $rapport->titre }}</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Soumis le {{ $rapport->date_soumission->format('d/m/Y à H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $rapport->statut === 'Validé' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($rapport->statut === 'Correction demandée' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                        {{ $rapport->statut }}
                    </span>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xs font-extrabold uppercase text-slate-400 tracking-wider">Description des Activités</h3>
                    <div class="bg-slate-900/80 p-4 rounded-xl text-slate-200 text-sm leading-relaxed whitespace-pre-line border border-slate-800">
                        {{ $rapport->contenu }}
                    </div>
                </div>

                @if($rapport->fichier)
                    <div class="glass-card p-4 rounded-xl flex items-center justify-between border border-slate-800">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-rose-400 text-2xl"></i>
                            <div>
                                <p class="text-sm font-semibold text-slate-100">Document attaché</p>
                                <p class="text-xs text-slate-400">PDF / Pièce justificative de travail</p>
                            </div>
                        </div>
                        <a href="{{ route('fichier', ['path' => $rapport->fichier]) }}" target="_blank" class="gradient-bg-primary text-white text-xs font-semibold px-4 py-2 rounded-lg flex items-center gap-1.5 shadow transition">
                            <i class="fa-solid fa-download"></i> Consulter le PDF
                        </a>
                    </div>
                @endif
            </div>

            <!-- Groq AI Analysis -->
            <div class="glass-panel p-6 rounded-2xl space-y-4 border border-indigo-500/30">
                <div class="flex justify-between items-center border-b border-indigo-500/20 pb-3">
                    <h3 class="font-bold text-indigo-300 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-indigo-400"></i> Synthèse & Conseils IA Groq
                    </h3>
                    <button onclick="lancerAnalyseIa()" id="btn-ia" class="gradient-bg-primary text-white text-xs font-semibold px-3.5 py-2 rounded-xl flex items-center gap-1.5 shadow transition hover:opacity-90">
                        <i class="fa-solid fa-robot"></i> <span id="btn-ia-text">{{ $rapport->analyse_ia ? 'Réanalyser' : 'Lancer l\'analyse IA' }}</span>
                    </button>
                </div>

                <div id="box-ia-result" class="{{ $rapport->analyse_ia ? '' : 'hidden' }} bg-slate-900/80 p-4 rounded-xl border border-slate-800 text-sm text-slate-200 leading-relaxed whitespace-pre-line">
                    {{ $rapport->analyse_ia }}
                </div>
                <div id="box-ia-error" class="hidden glass-panel border border-rose-500/40 text-rose-300 rounded-xl p-4 text-sm"></div>
            </div>
        </div>

        <!-- Sidebar Actions & Comments -->
        <div class="space-y-6">
            <!-- Validation & Feedback Form -->
            <div class="glass-panel p-6 rounded-2xl space-y-5 border border-slate-800">
                <h3 class="font-bold text-slate-100 text-lg border-b border-slate-700/60 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-check-double text-emerald-400"></i> Décision de l'Encadrant
                </h3>

                <form action="{{ route('encadrant.rapports.valider', $rapport) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Décision</label>
                        <select name="statut" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="Validé" {{ $rapport->statut === 'Validé' ? 'selected' : '' }}>✅ Valider le rapport</option>
                            <option value="Correction demandée" {{ $rapport->statut === 'Correction demandée' ? 'selected' : '' }}>⚠️ Demander des corrections</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-200 mb-2">Commentaires / Remarques</label>
                        <textarea name="commentaire_encadrant" rows="4" placeholder="Ajoutez un commentaire constructif pour le stagiaire..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">{{ $rapport->commentaire_encadrant }}</textarea>
                    </div>

                    <button type="submit" class="w-full gradient-bg-primary text-white py-3 rounded-xl font-semibold text-sm hover:opacity-90 shadow-lg shadow-indigo-600/30 transition">
                        Enregistrer la décision
                    </button>
                </form>
            </div>

            <!-- Stagiaire Profile Quick Card -->
            <div class="glass-panel p-5 rounded-2xl space-y-3 border border-slate-800">
                <h4 class="text-xs font-extrabold uppercase text-slate-400 tracking-wider">Aperçu Stagiaire</h4>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full gradient-bg-primary flex items-center justify-center text-white text-lg font-bold">
                        {{ strtoupper(substr($rapport->stagiaire->nom, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-100 text-sm">{{ $rapport->stagiaire->nom_complet }}</p>
                        <p class="text-xs text-indigo-400">{{ $rapport->stagiaire->filiere }}</p>
                    </div>
                </div>

                <div class="pt-2 space-y-2 text-xs">
                    <div class="flex justify-between items-center py-1 border-b border-slate-800">
                        <span class="text-slate-400">Progression Globale</span>
                        <span class="font-bold text-indigo-400">{{ $rapport->stagiaire->progression_globale }}%</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-slate-400">Taux de présence</span>
                        <span class="font-bold text-emerald-400">{{ $rapport->stagiaire->taux_presence }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function lancerAnalyseIa() {
    const btn = document.getElementById('btn-ia');
    const txt = document.getElementById('btn-ia-text');
    const box = document.getElementById('box-ia-result');
    const err = document.getElementById('box-ia-error');

    btn.disabled = true;
    txt.textContent = 'Analyse par Groq...';
    err.classList.add('hidden');

    try {
        const r = await fetch('{{ route('encadrant.rapports.analyse_ia', $rapport) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await r.json();
        if (data.result) {
            box.textContent = data.result;
            box.classList.remove('hidden');
        } else {
            err.textContent = '⚠️ ' + (data.error ?? 'Erreur d\'analyse');
            err.classList.remove('hidden');
        }
    } catch(e) {
        err.textContent = '⚠️ Erreur de connexion avec l\'IA.';
        err.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        txt.textContent = 'Réanalyser';
    }
}
</script>
@endpush
