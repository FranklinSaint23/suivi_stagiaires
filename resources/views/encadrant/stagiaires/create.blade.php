@extends('layouts.app')
@section('title', 'Ajouter un stagiaire')

@section('sidebar')
    @include('encadrant.partials.sidebar')
@endsection

@section('content')
<h1 class="text-xl font-bold text-purple-900 mb-6">Ajouter un stagiaire</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form action="{{ route('encadrant.stagiaires.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sexe *</label>
                <select name="sexe" required class="w-full border rounded px-3 py-2 text-sm">
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                <select name="filiere" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="IDE1">IDE1</option>
                    <option value="IDE2">IDE2</option>
                    <option value="IDE3">IDE3</option>
                    <option value="AS">AS</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                <input type="date" name="naissance" value="{{ old('naissance') }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de naissance</label>
                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de stage</label>
                <select name="lieu" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="Hôpital Régional">Hôpital Régional</option>
                    <option value="Hôpital de District">Hôpital de District</option>
                    <option value="CMA TYO">CMA TYO</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-purple-700 text-white px-5 py-2 rounded hover:bg-purple-800 text-sm">Enregistrer</button>
            <a href="{{ route('encadrant.stagiaires.index') }}" class="border px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-50">Annuler</a>
        </div>
    </form>
</div>
@endsection
