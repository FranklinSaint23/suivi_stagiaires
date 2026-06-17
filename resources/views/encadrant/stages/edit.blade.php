@extends('layouts.app')
@section('title', 'Modifier le stage')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Modifier le stage</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-xl">
    <form action="{{ route('encadrant.stages.update', $stage) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stagiaire</label>
                <select name="stagiaire_id" required class="w-full border rounded px-3 py-2 text-sm">
                    @foreach($stagiaires as $s)
                        <option value="{{ $s->id }}" {{ $stage->stagiaire_id == $s->id ? 'selected' : '' }}>
                            {{ $s->nom }} {{ $s->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                    <input type="date" name="date_debut" value="{{ $stage->date_debut->format('Y-m-d') }}" required class="w-full border rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                    <input type="date" name="date_fin" value="{{ $stage->date_fin->format('Y-m-d') }}" required class="w-full border rounded px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Établissement</label>
                <input type="text" name="etablissement" value="{{ $stage->etablissement }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thème</label>
                <input type="text" name="theme" value="{{ $stage->theme }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rapport (PDF) — remplacer</label>
                <input type="file" name="rapport" accept=".pdf" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Convention (PDF) — remplacer</label>
                <input type="file" name="convention" accept=".pdf" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">Mettre à jour</button>
            <a href="{{ route('encadrant.stages.index') }}" class="border px-4 py-2 rounded text-sm text-gray-600">Annuler</a>
        </div>
    </form>
</div>
@endsection
