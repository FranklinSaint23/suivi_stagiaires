@extends('layouts.app')
@section('title', 'Profil stagiaire')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="flex items-center gap-4 mb-6">
    @if($stagiaire->photo)
        <img src="{{ asset('storage/' . $stagiaire->photo) }}" class="w-20 h-20 rounded-full object-cover shadow">
    @else
        <div class="w-20 h-20 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 text-2xl font-bold shadow">
            {{ strtoupper(substr($stagiaire->nom, 0, 1)) }}
        </div>
    @endif
    <div>
        <h1 class="text-2xl font-bold text-purple-900">{{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h1>
        <p class="text-gray-500 text-sm">{{ $stagiaire->filiere }} · {{ $stagiaire->lieu }}</p>
        <p class="text-gray-400 text-xs">{{ $stagiaire->email }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold text-gray-700 mb-3">Informations personnelles</h2>
        <dl class="space-y-2 text-sm">
            <div class="flex"><dt class="w-32 text-gray-500">Sexe</dt><dd>{{ $stagiaire->sexe }}</dd></div>
            <div class="flex"><dt class="w-32 text-gray-500">Naissance</dt><dd>{{ $stagiaire->naissance?->format('d/m/Y') }}</dd></div>
            <div class="flex"><dt class="w-32 text-gray-500">Lieu naiss.</dt><dd>{{ $stagiaire->lieu_naissance }}</dd></div>
            <div class="flex"><dt class="w-32 text-gray-500">Téléphone</dt><dd>{{ $stagiaire->telephone }}</dd></div>
            <div class="flex"><dt class="w-32 text-gray-500">Taux présence</dt>
                <dd><span class="font-bold {{ $stagiaire->taux_presence >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ $stagiaire->taux_presence }}%</span></dd>
            </div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex justify-between items-center mb-3">
            <h2 class="font-semibold text-gray-700">Stages</h2>
            <a href="{{ route('encadrant.stages.create', ['stagiaire_id' => $stagiaire->id]) }}"
               class="text-xs bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700">+ Ajouter</a>
        </div>
        @forelse($stagiaire->stages as $stage)
            <div class="border rounded p-3 mb-2 text-sm">
                <p class="font-medium">{{ $stage->theme }}</p>
                <p class="text-gray-500">{{ $stage->etablissement }}</p>
                <p class="text-xs text-gray-400">{{ $stage->date_debut->format('d/m/Y') }} → {{ $stage->date_fin->format('d/m/Y') }}</p>
                <div class="flex gap-2 mt-2">
                    <a href="{{ route('encadrant.stages.edit', $stage) }}"
                       class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Modifier</a>
                    <form action="{{ route('encadrant.stages.destroy', $stage) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce stage ?')">
                        @csrf @method('DELETE')
                        <button class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Aucun stage enregistré.</p>
        @endforelse
    </div>
</div>

<div class="flex flex-wrap gap-3">
    <a href="{{ route('encadrant.pdf.attestation', $stagiaire) }}"
       class="bg-purple-700 text-white px-4 py-2 rounded text-sm hover:bg-purple-800">📜 Attestation PDF</a>
    <a href="{{ route('encadrant.pdf.carte', $stagiaire) }}"
       class="bg-purple-600 text-white px-4 py-2 rounded text-sm hover:bg-purple-700">🪪 Carte PDF</a>
    <a href="{{ route('encadrant.stagiaires.edit', $stagiaire) }}"
       class="bg-yellow-500 text-white px-4 py-2 rounded text-sm hover:bg-yellow-600">✏️ Modifier</a>
    <button onclick="genererRapport()" id="btn-rapport"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold">
        🤖 <span id="btn-rapport-text">Rapport IA</span>
    </button>
    <a href="{{ route('encadrant.stagiaires.index') }}"
       class="border px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-50">← Retour</a>
</div>

{{-- Rapport IA --}}
<div id="ai-rapport-box" class="hidden mt-6 bg-indigo-50 border border-indigo-200 rounded-xl p-5">
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-bold text-indigo-800">🤖 Rapport de performance IA</h3>
        <button onclick="window.print()" class="text-xs bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-3 py-1 rounded">Imprimer</button>
    </div>
    <div id="ai-rapport-text" class="text-sm text-gray-700 leading-relaxed whitespace-pre-line"></div>
</div>
<div id="ai-rapport-error" class="hidden mt-4 bg-red-50 border border-red-300 text-red-700 rounded-xl p-4 text-sm"></div>
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
