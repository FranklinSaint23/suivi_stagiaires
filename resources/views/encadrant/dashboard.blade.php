@extends('layouts.app')
@section('title', 'Dashboard Encadrant')

@section('sidebar')
    <p class="text-xs uppercase text-purple-300 mb-3 px-2">Encadrant</p>
    <a href="{{ route('encadrant.dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">🏠 Tableau de bord</a>
    <a href="{{ route('encadrant.stagiaires.index') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">👥 Stagiaires</a>
    <a href="{{ route('encadrant.stages.index') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📋 Stages</a>
    <a href="{{ route('encadrant.demandes.index') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📩 Demandes</a>
    <a href="{{ route('encadrant.presences.create') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">✅ Pointer présence</a>
    <a href="{{ route('encadrant.presences.index') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📅 Récap présences</a>
    <a href="{{ route('encadrant.messages.index') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">💬 Messages</a>
    <a href="{{ route('encadrant.pdf.choix_attestation') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📜 Attestation PDF</a>
    <a href="{{ route('encadrant.pdf.choix_carte') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">🪪 Carte stagiaire</a>
    <a href="{{ route('encadrant.pdf.presences') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📊 Export présences PDF</a>
    <a href="{{ route('encadrant.carte_interactive') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">🗺️ Carte interactive</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-purple-900 mb-6">Tableau de bord Encadrant</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-600">
        <p class="text-sm text-gray-500">Stagiaires</p>
        <p class="text-3xl font-bold text-purple-800">{{ $stagiaires->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Demandes en attente</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $demandes->where('etat', 'En attente')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Demandes validées</p>
        <p class="text-3xl font-bold text-green-700">{{ $demandes->where('etat', 'Validée')->count() }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-5">
    <h2 class="font-semibold text-gray-700 mb-4">Demandes de stage récentes</h2>
    @if($demandes->isEmpty())
        <p class="text-gray-500 text-sm">Aucune demande.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-purple-50 text-purple-900">
                    <tr>
                        <th class="px-3 py-2 text-left">Nom</th>
                        <th class="px-3 py-2 text-left">Prénom</th>
                        <th class="px-3 py-2 text-left">Filière</th>
                        <th class="px-3 py-2 text-left">Lieu</th>
                        <th class="px-3 py-2 text-left">État</th>
                        <th class="px-3 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($demandes as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $d->nom }}</td>
                        <td class="px-3 py-2">{{ $d->prenom }}</td>
                        <td class="px-3 py-2">{{ $d->filiere }}</td>
                        <td class="px-3 py-2">{{ $d->lieu }}</td>
                        <td class="px-3 py-2">
                            @if($d->etat === 'Validée')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Validée</span>
                            @elseif($d->etat === 'Refusée')
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Refusée</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">En attente</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 flex gap-2">
                            <a href="{{ route('encadrant.demandes.show', $d) }}"
                               class="bg-purple-600 text-white px-2 py-1 rounded text-xs hover:bg-purple-700">Voir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
