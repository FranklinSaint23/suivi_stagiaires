@extends('layouts.app')
@section('title', 'Demandes de stage')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-inbox text-indigo-400"></i>
                <span>Demandes de <span class="gradient-text">Stage</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Consultez, validez ou refusez les candidatures entrantes</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="glass-panel rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900/90 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3.5">Candidat</th>
                        <th class="px-4 py-3.5">Filière</th>
                        <th class="px-4 py-3.5">Lieu</th>
                        <th class="px-4 py-3.5">Période</th>
                        <th class="px-4 py-3.5 text-center">État</th>
                        <th class="px-4 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-slate-300">
                    @forelse($demandes as $d)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-4 py-3 font-semibold text-white">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 text-indigo-400 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($d->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-slate-100">{{ $d->prenom }} {{ $d->nom }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $d->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-300 font-medium">{{ $d->filiere }}</td>
                        <td class="px-4 py-3 text-slate-400">
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-slate-500 text-xs"></i> {{ $d->lieu }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-400 font-mono">
                            {{ $d->date_debut->format('d/m/Y') }} → {{ $d->date_fin->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($d->etat === 'Validée')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Validée
                                </span>
                            @elseif($d->etat === 'Refusée')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i> Refusée
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <i class="fa-solid fa-clock text-[10px]"></i> En attente
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                <a href="{{ route('encadrant.demandes.show', $d) }}"
                                   class="inline-flex items-center gap-1 bg-slate-800 hover:bg-slate-700 text-slate-200 px-2.5 py-1.5 rounded-lg text-xs font-medium border border-slate-700 transition">
                                    <i class="fa-solid fa-eye"></i> Détails
                                </a>
                                @if($d->etat === 'En attente')
                                    <button onclick="openAcceptModal({{ $d->id }})"
                                            class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-500 text-white px-2.5 py-1.5 rounded-lg text-xs font-semibold shadow-md transition">
                                        <i class="fa-solid fa-check"></i> Accepter
                                    </button>
                                    <form action="{{ route('encadrant.demandes.refuse', $d) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Refuser cette demande ?')">
                                        @csrf
                                        <button class="inline-flex items-center gap-1 bg-rose-600 hover:bg-rose-500 text-white px-2.5 py-1.5 rounded-lg text-xs font-semibold shadow-md transition">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                            <i class="fa-solid fa-inbox text-4xl mb-3 opacity-30 block"></i>
                            <p class="text-sm font-medium">Aucune demande enregistrée pour le moment.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Accepter -->
<div id="acceptModal" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="glass-panel rounded-2xl shadow-2xl p-6 w-full max-w-sm border border-slate-800 relative">
        <h2 class="text-lg font-bold text-slate-100 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-key text-emerald-400"></i> Attribuer un mot de passe
        </h2>
        <form id="acceptForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Mot de passe temporaire *</label>
                <input type="text" name="password" required minlength="6"
                       class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20"
                       placeholder="Ex: Stagiaire2026!">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 gradient-bg-primary hover:opacity-95 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg transition">
                    Valider
                </button>
                <button type="button" onclick="closeModal()"
                        class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAcceptModal(id) {
    document.getElementById('acceptForm').action = '/encadrant/demandes/' + id + '/accepter';
    document.getElementById('acceptModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('acceptModal').classList.add('hidden');
}
</script>
@endpush

