@extends('layouts.app')
@section('title', 'Choisir stagiaire — Carte')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Générer une carte stagiaire</h1>
<div class="bg-white rounded-xl shadow p-6 max-w-md">
    <label class="block text-sm font-medium text-gray-700 mb-2">Choisir le stagiaire</label>
    <select id="sel" class="w-full border rounded px-3 py-2 text-sm mb-4">
        <option value="">-- Choisir --</option>
        @foreach($stagiaires as $s)
            <option value="{{ $s->id }}">{{ $s->nom }} {{ $s->prenom }}</option>
        @endforeach
    </select>
    <button onclick="if(document.getElementById('sel').value) window.location='/encadrant/pdf/carte/'+document.getElementById('sel').value"
            class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">
        🪪 Télécharger la carte
    </button>
</div>
@endsection
