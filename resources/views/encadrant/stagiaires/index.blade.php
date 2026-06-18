@extends('layouts.app')
@section('title', 'Stagiaires')

@section('sidebar')
    <p class="text-xs uppercase text-purple-300 mb-3 px-2">Encadrant</p>
    <a href="{{ route('encadrant.dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">🏠 Tableau de bord</a>
    <a href="{{ route('encadrant.stagiaires.index') }}" class="block px-3 py-2 rounded bg-purple-700 text-sm">👥 Stagiaires</a>
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
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-purple-900">Stagiaires</h1>
    <a href="{{ route('encadrant.stagiaires.create') }}"
       class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800 text-sm">+ Ajouter</a>
</div>

<div class="bg-white rounded-xl shadow p-4 mb-4">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom ou prénom..."
               class="border border-gray-300 rounded px-3 py-2 text-sm flex-1 focus:ring-2 focus:ring-purple-500">
        <button class="bg-purple-700 text-white px-4 py-2 rounded text-sm hover:bg-purple-800">Rechercher</button>
        @if($search)
            <a href="{{ route('encadrant.stagiaires.index') }}" class="border px-3 py-2 rounded text-sm text-gray-600">Réinitialiser</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-purple-50 text-purple-900">
            <tr>
                <th class="px-4 py-3 text-left">Photo</th>
                <th class="px-4 py-3 text-left">Nom</th>
                <th class="px-4 py-3 text-left">Prénom</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Filière</th>
                <th class="px-4 py-3 text-left">Lieu</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($stagiaires as $s)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($s->photo)
                        <img src="{{ route('fichier', ['path' => $s->photo]) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 font-bold">
                            {{ strtoupper(substr($s->nom, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium">{{ $s->nom }}</td>
                <td class="px-4 py-3">{{ $s->prenom }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $s->email }}</td>
                <td class="px-4 py-3">{{ $s->filiere }}</td>
                <td class="px-4 py-3">{{ $s->lieu }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('encadrant.stagiaires.show', $s) }}"
                       class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs hover:bg-blue-200">Profil</a>
                    <a href="{{ route('encadrant.stagiaires.edit', $s) }}"
                       class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs hover:bg-yellow-200">Modifier</a>
                    <form action="{{ route('encadrant.stagiaires.destroy', $s) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce stagiaire ?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs hover:bg-red-200">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-400">Aucun stagiaire trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
