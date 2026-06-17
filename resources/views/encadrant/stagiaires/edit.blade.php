@extends('layouts.app')
@section('title', 'Modifier le stagiaire')
@section('sidebar') @include('encadrant.partials.sidebar') @endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Modifier : {{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form action="{{ route('encadrant.stagiaires.update', $stagiaire) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sexe</label>
                <select name="sexe" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="M" {{ $stagiaire->sexe == 'M' ? 'selected' : '' }}>M</option>
                    <option value="F" {{ $stagiaire->sexe == 'F' ? 'selected' : '' }}>F</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                <select name="filiere" class="w-full border rounded px-3 py-2 text-sm">
                    @foreach(['IDE1','IDE2','IDE3','AS'] as $f)
                        <option value="{{ $f }}" {{ $stagiaire->filiere == $f ? 'selected' : '' }}>{{ $f }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $stagiaire->nom) }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $stagiaire->prenom) }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input type="tel" name="telephone" value="{{ old('telephone', $stagiaire->telephone) }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $stagiaire->email) }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe (laisser vide = inchangé)</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lieu</label>
                <select name="lieu" class="w-full border rounded px-3 py-2 text-sm">
                    @foreach(['Hôpital Régional','Hôpital de District','CMA TYO'] as $l)
                        <option value="{{ $l }}" {{ $stagiaire->lieu == $l ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle photo (optionnel)</label>
                @if($stagiaire->photo)
                    <img src="{{ asset('storage/' . $stagiaire->photo) }}" class="w-16 h-16 rounded-full object-cover mb-2">
                @endif
                <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">Mettre à jour</button>
            <a href="{{ route('encadrant.stagiaires.index') }}" class="border px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-50">Annuler</a>
        </div>
    </form>
</div>
@endsection
