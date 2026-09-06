@extends('layouts.app')
@section('title', 'Ajouter un Stagiaire')

@section('sidebar')
    @include('encadrant.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-800">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
            <i class="fa-solid fa-user-plus text-indigo-400"></i>
            <span>Ajouter un <span class="gradient-text">Stagiaire</span></span>
        </h1>
        <p class="text-sm text-slate-400 mt-1">Créez un nouveau profil stagiaire et attribuez ses accès</p>
    </div>

    <div class="glass-panel rounded-2xl p-6 sm:p-8 max-w-2xl border border-slate-800 shadow-xl">
        <form action="{{ route('encadrant.stagiaires.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Sexe *</label>
                    <select name="sexe" required class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="M" class="bg-slate-900 text-slate-100">Homme (M)</option>
                        <option value="F" class="bg-slate-900 text-slate-100">Femme (F)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Filière</label>
                    <select name="filiere" class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="IDE1" class="bg-slate-900 text-slate-100">IDE1</option>
                        <option value="IDE2" class="bg-slate-900 text-slate-100">IDE2</option>
                        <option value="IDE3" class="bg-slate-900 text-slate-100">IDE3</option>
                        <option value="AS" class="bg-slate-900 text-slate-100">AS</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Date de naissance</label>
                    <input type="date" name="naissance" value="{{ old('naissance') }}" 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Téléphone</label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Mot de passe *</label>
                    <input type="password" name="password" required 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Lieu de stage</label>
                    <select name="lieu" class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700/80 rounded-xl text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="Hôpital Régional" class="bg-slate-900 text-slate-100">Hôpital Régional</option>
                        <option value="Hôpital de District" class="bg-slate-900 text-slate-100">Hôpital de District</option>
                        <option value="CMA TYO" class="bg-slate-900 text-slate-100">CMA TYO</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Photo d'identité</label>
                    <input type="file" name="photo" accept="image/*" 
                           class="w-full bg-slate-900 border border-slate-700/80 rounded-xl p-2 text-xs text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                </div>
            </div>

            <div class="pt-3 flex items-center gap-3">
                <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-semibold py-3 px-5 rounded-xl shadow-lg shadow-indigo-600/30 transition text-sm flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Enregistrer</span>
                </button>
                <a href="{{ route('encadrant.stagiaires.index') }}" 
                   class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-5 py-3 rounded-xl text-sm font-medium transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

