@extends('layouts.app')
@section('title', 'Stages')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-purple-900">Stages</h1>
    <a href="{{ route('encadrant.stages.create') }}"
       class="bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-800 text-sm">+ Ajouter</a>
</div>

<div class="bg-white rounded-xl shadow p-4 mb-4">
    <form method="GET" class="flex gap-3 flex-wrap">
        <input type="text" name="theme" value="{{ request('theme') }}" placeholder="Thème..."
               class="border rounded px-3 py-2 text-sm">
        <select name="stagiaire_id" class="border rounded px-3 py-2 text-sm">
            <option value="">Tous les stagiaires</option>
            @foreach($stagiaires as $s)
                <option value="{{ $s->id }}" {{ request('stagiaire_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->nom }} {{ $s->prenom }}
                </option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2 text-sm">
        <button class="bg-purple-700 text-white px-4 py-2 rounded text-sm">Filtrer</button>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-purple-50 text-purple-900">
            <tr>
                <th class="px-4 py-3 text-left">Stagiaire</th>
                <th class="px-4 py-3 text-left">Thème</th>
                <th class="px-4 py-3 text-left">Établissement</th>
                <th class="px-4 py-3 text-left">Début</th>
                <th class="px-4 py-3 text-left">Fin</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($stages as $stage)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $stage->stagiaire?->nom }} {{ $stage->stagiaire?->prenom }}</td>
                <td class="px-4 py-3 font-medium">{{ $stage->theme }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $stage->etablissement }}</td>
                <td class="px-4 py-3">{{ $stage->date_debut->format('d/m/Y') }}</td>
                <td class="px-4 py-3">{{ $stage->date_fin->format('d/m/Y') }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('encadrant.stages.edit', $stage) }}"
                       class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Modifier</a>
                    <form action="{{ route('encadrant.stages.destroy', $stage) }}" method="POST"
                          onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Aucun stage trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
