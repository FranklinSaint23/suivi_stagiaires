@extends('layouts.app')
@section('title', 'Détail demande')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-id-card text-indigo-400"></i> Demande de {{ $demande->prenom }} {{ $demande->nom }}
            </h1>
            <p class="text-slate-400 text-sm mt-1">Consultez et validez le dossier de candidature</p>
        </div>
        <a href="{{ route('encadrant.demandes.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Info Card -->
        <div class="glass-panel p-6 rounded-2xl space-y-4">
            <div class="flex items-center gap-4 border-b border-slate-700/60 pb-4">
                @if($demande->photo)
                    <img src="{{ route('fichier', ['path' => $demande->photo]) }}" class="w-16 h-16 rounded-full object-cover ring-2 ring-indigo-500 shadow">
                @else
                    <div class="w-16 h-16 rounded-full gradient-bg-primary flex items-center justify-center text-white text-xl font-bold">
                        {{ strtoupper(substr($demande->nom, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="font-bold text-slate-100 text-lg">{{ $demande->prenom }} {{ $demande->nom }}</h2>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $demande->etat === 'Validée' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : ($demande->etat === 'Refusée' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                        {{ $demande->etat }}
                    </span>
                </div>
            </div>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <dt class="text-slate-400 font-medium">Sexe</dt>
                    <dd class="text-slate-200 font-semibold">{{ $demande->sexe }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <dt class="text-slate-400 font-medium">Email</dt>
                    <dd class="text-slate-200 font-semibold">{{ $demande->email }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <dt class="text-slate-400 font-medium">Téléphone</dt>
                    <dd class="text-slate-200 font-semibold">{{ $demande->telephone }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <dt class="text-slate-400 font-medium">Filière</dt>
                    <dd class="text-slate-200 font-semibold">{{ $demande->filiere }}</dd>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-800">
                    <dt class="text-slate-400 font-medium">Lieu souhaité</dt>
                    <dd class="text-slate-200 font-semibold">{{ $demande->lieu }}</dd>
                </div>
                <div class="flex justify-between py-1">
                    <dt class="text-slate-400 font-medium">Période</dt>
                    <dd class="text-indigo-300 font-mono text-xs">
                        {{ $demande->date_debut->format('d/m/Y') }} → {{ $demande->date_fin->format('d/m/Y') }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Documents Card -->
        <div class="glass-panel p-6 rounded-2xl space-y-4">
            <h2 class="text-lg font-bold text-slate-100 flex items-center gap-2 border-b border-slate-700/60 pb-3">
                <i class="fa-solid fa-folder-open text-indigo-400"></i> Documents joints
            </h2>

            <div class="space-y-3">
                @if($demande->cv)
                    <div class="glass-card p-4 rounded-xl flex items-center justify-between border border-slate-800">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-rose-400 text-xl"></i>
                            <div>
                                <p class="text-sm font-semibold text-slate-100">Curriculum Vitae (CV)</p>
                                <a href="{{ route('fichier', ['path' => $demande->cv]) }}" target="_blank" class="text-xs text-indigo-400 hover:underline">Consulter le document</a>
                            </div>
                        </div>
                        <button onclick="analyserCv()" id="btn-cv" class="gradient-bg-primary text-white text-xs font-semibold px-3 py-2 rounded-lg flex items-center gap-1.5 shadow transition hover:opacity-90">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> <span id="btn-cv-text">Analyser IA</span>
                        </button>
                    </div>
                @endif

                @if($demande->lettre)
                    <div class="glass-card p-4 rounded-xl flex items-center gap-3 border border-slate-800">
                        <i class="fa-solid fa-file-lines text-indigo-400 text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold text-slate-100">Lettre de motivation</p>
                            <a href="{{ route('fichier', ['path' => $demande->lettre]) }}" target="_blank" class="text-xs text-indigo-400 hover:underline">Consulter le document</a>
                        </div>
                    </div>
                @endif

                @if($demande->certificat)
                    <div class="glass-card p-4 rounded-xl flex items-center gap-3 border border-slate-800">
                        <i class="fa-solid fa-certificate text-amber-400 text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold text-slate-100">Certificat de scolarité</p>
                            <a href="{{ route('fichier', ['path' => $demande->certificat]) }}" target="_blank" class="text-xs text-indigo-400 hover:underline">Consulter le document</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- AI Analysis Card -->
    <div id="ai-cv-result" class="hidden glass-panel border border-indigo-500/30 rounded-2xl p-6 space-y-3">
        <h3 class="font-bold text-indigo-300 text-lg flex items-center gap-2 border-b border-indigo-500/20 pb-2">
            <i class="fa-solid fa-robot"></i> Analyse IA du CV
        </h3>
        <div id="ai-cv-text" class="text-sm text-slate-200 bg-slate-900/60 p-4 rounded-xl border border-slate-800 whitespace-pre-line leading-relaxed"></div>
    </div>
    <div id="ai-cv-error" class="hidden glass-panel border border-rose-500/40 text-rose-300 rounded-2xl p-5 text-sm"></div>

    @if($demande->etat === 'En attente')
    <div class="glass-panel p-6 rounded-2xl flex items-center gap-4">
        <button onclick="document.getElementById('acceptModal').classList.remove('hidden')"
                class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition flex items-center gap-2 shadow-lg shadow-emerald-600/20">
            <i class="fa-solid fa-check"></i> Accepter la demande
        </button>
        <form action="{{ route('encadrant.demandes.refuse', $demande) }}" method="POST">
            @csrf
            <button class="bg-rose-600 hover:bg-rose-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition flex items-center gap-2 shadow-lg shadow-rose-600/20"
                    onclick="return confirm('Refuser cette demande ?')">
                <i class="fa-solid fa-xmark"></i> Refuser
            </button>
        </form>
    </div>
    @endif
</div>

<!-- Modal Acceptation -->
<div id="acceptModal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="glass-panel border border-slate-700/80 rounded-2xl shadow-2xl p-6 w-full max-w-md space-y-5">
        <div class="flex items-center justify-between border-b border-slate-700/60 pb-3">
            <h2 class="text-lg font-bold text-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-key text-indigo-400"></i> Attribuer un mot de passe
            </h2>
            <button type="button" onclick="document.getElementById('acceptModal').classList.add('hidden')" class="text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('encadrant.demandes.accept', $demande) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Mot de passe pour le stagiaire</label>
                <input type="text" name="password" required minlength="6" placeholder="Saisir un mot de passe sécurisé..."
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('acceptModal').classList.add('hidden')"
                        class="px-4 py-2.5 rounded-xl text-slate-300 border border-slate-700 hover:bg-slate-800 text-sm font-semibold transition">
                    Annuler
                </button>
                <button type="submit" class="gradient-bg-primary text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 shadow-lg transition">
                    Valider et Créer le Compte
                </button>
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
    txt.textContent = 'Analyse…';
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
        txt.textContent = 'Analyser IA';
    }
}
</script>
@endpush
