@extends('layouts.app')
@section('title', 'Détail demande')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Demande de {{ $demande->prenom }} {{ $demande->nom }}</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Informations personnelles</h2>
        @if($demande->photo)
            <img src="{{ route('fichier', ['path' => $demande->photo]) }}" class="w-24 h-24 rounded-full object-cover mb-4">
        @endif
        <dl class="space-y-2 text-sm">
            <div class="flex"><dt class="w-28 text-gray-500">Sexe</dt><dd>{{ $demande->sexe }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">Email</dt><dd>{{ $demande->email }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">Téléphone</dt><dd>{{ $demande->telephone }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">Filière</dt><dd>{{ $demande->filiere }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">Lieu</dt><dd>{{ $demande->lieu }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">Début</dt><dd>{{ $demande->date_debut->format('d/m/Y') }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">Fin</dt><dd>{{ $demande->date_fin->format('d/m/Y') }}</dd></div>
            <div class="flex"><dt class="w-28 text-gray-500">État</dt>
                <dd>
                    @if($demande->etat === 'Validée')<span class="text-green-600 font-medium">Validée</span>
                    @elseif($demande->etat === 'Refusée')<span class="text-red-600 font-medium">Refusée</span>
                    @else<span class="text-yellow-600 font-medium">En attente</span>@endif
                </dd>
            </div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Documents</h2>
        @if($demande->cv)
            <a href="{{ route('fichier', ['path' => $demande->cv]) }}" target="_blank"
               class="block mb-2 text-purple-700 underline text-sm">📄 Voir le CV</a>
            <button onclick="analyserCv()" id="btn-cv"
                    class="w-full mt-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center justify-center gap-2">
                <span>🤖</span> <span id="btn-cv-text">Analyser le CV avec l'IA</span>
            </button>
        @endif
        @if($demande->lettre)
            <a href="{{ route('fichier', ['path' => $demande->lettre]) }}" target="_blank"
               class="block mt-2 mb-2 text-purple-700 underline text-sm">📄 Lettre de motivation</a>
        @endif
        @if($demande->certificat)
            <a href="{{ route('fichier', ['path' => $demande->certificat]) }}" target="_blank"
               class="block mb-2 text-purple-700 underline text-sm">📄 Certificat de scolarité</a>
        @endif
    </div>
</div>

{{-- Résultat analyse CV IA --}}
<div id="ai-cv-result" class="hidden mt-6 bg-indigo-50 border border-indigo-200 rounded-xl p-5">
    <h3 class="font-bold text-indigo-800 mb-3">🤖 Analyse IA du CV</h3>
    <div id="ai-cv-text" class="text-sm text-gray-700 whitespace-pre-line leading-relaxed"></div>
</div>
<div id="ai-cv-error" class="hidden mt-4 bg-red-50 border border-red-300 text-red-700 rounded-xl p-4 text-sm"></div>

@if($demande->etat === 'En attente')
<div class="mt-6 flex gap-3">
    <button onclick="document.getElementById('acceptModal').classList.remove('hidden')"
            class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">✅ Accepter</button>
    <form action="{{ route('encadrant.demandes.refuse', $demande) }}" method="POST">
        @csrf
        <button class="bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700"
                onclick="return confirm('Refuser ?')">❌ Refuser</button>
    </form>
</div>
@endif

<a href="{{ route('encadrant.demandes.index') }}" class="inline-block mt-4 text-sm text-gray-500 hover:underline">← Retour</a>

<!-- Modal -->
<div id="acceptModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm">
        <h2 class="text-lg font-bold text-purple-900 mb-4">Attribuer un mot de passe</h2>
        <form action="{{ route('encadrant.demandes.accept', $demande) }}" method="POST">
            @csrf
            <input type="text" name="password" required minlength="6" placeholder="Mot de passe..."
                   class="w-full border rounded px-3 py-2 text-sm mb-4">
            <div class="flex gap-3">
                <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded text-sm">Valider</button>
                <button type="button" onclick="document.getElementById('acceptModal').classList.add('hidden')"
                        class="border px-4 py-2 rounded text-sm text-gray-600">Annuler</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function analyserCv() {
    const btn = document.getElementById('btn-cv');
    const txt = document.getElementById('btn-cv-text');
    const res = document.getElementById('ai-cv-result');
    const err = document.getElementById('ai-cv-error');

    btn.disabled = true;
    txt.textContent = 'Analyse en cours…';
    res.classList.add('hidden');
    err.classList.add('hidden');

    try {
        const r = await fetch('{{ route('encadrant.ai.analyse_cv', $demande) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await r.json();
        if (data.result) {
            document.getElementById('ai-cv-text').textContent = data.result;
            res.classList.remove('hidden');
        } else {
            err.textContent = '⚠️ ' + (data.error ?? 'Erreur inconnue');
            err.classList.remove('hidden');
        }
    } catch(e) {
        err.textContent = '⚠️ Erreur de connexion.';
        err.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        txt.textContent = 'Analyser le CV avec l\'IA';
    }
}
</script>
@endpush
