@extends('layouts.app')
@section('title', 'Demandes de stage')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-2xl font-bold text-purple-900 mb-6">Demandes de stage</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-purple-50 text-purple-900">
            <tr>
                <th class="px-4 py-3 text-left">Nom complet</th>
                <th class="px-4 py-3 text-left">Filière</th>
                <th class="px-4 py-3 text-left">Lieu</th>
                <th class="px-4 py-3 text-left">Période</th>
                <th class="px-4 py-3 text-left">État</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($demandes as $d)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">{{ $d->prenom }} {{ $d->nom }}</td>
                <td class="px-4 py-3">{{ $d->filiere }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $d->lieu }}</td>
                <td class="px-4 py-3 text-xs text-gray-400">{{ $d->date_debut->format('d/m/Y') }} → {{ $d->date_fin->format('d/m/Y') }}</td>
                <td class="px-4 py-3">
                    @if($d->etat === 'Validée')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Validée</span>
                    @elseif($d->etat === 'Refusée')
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Refusée</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">En attente</span>
                    @endif
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('encadrant.demandes.show', $d) }}"
                       class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Détails</a>
                    @if($d->etat === 'En attente')
                        <button onclick="openAcceptModal({{ $d->id }})"
                                class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Accepter</button>
                        <form action="{{ route('encadrant.demandes.refuse', $d) }}" method="POST"
                              onsubmit="return confirm('Refuser cette demande ?')">
                            @csrf
                            <button class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Refuser</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Aucune demande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Accepter -->
<div id="acceptModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm">
        <h2 class="text-lg font-bold text-purple-900 mb-4">Attribuer un mot de passe</h2>
        <form id="acceptForm" method="POST">
            @csrf
            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
            <input type="text" name="password" required minlength="6"
                   class="w-full border rounded px-3 py-2 text-sm mb-4 focus:ring-2 focus:ring-purple-500">
            <div class="flex gap-3">
                <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded text-sm hover:bg-purple-800">Valider</button>
                <button type="button" onclick="closeModal()"
                        class="border px-4 py-2 rounded text-sm text-gray-600">Annuler</button>
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
