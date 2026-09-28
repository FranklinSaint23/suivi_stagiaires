@extends('layouts.app')
@section('title', 'Ajouter un Stagiaire')

@section('sidebar')
    @include('encadrant.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-3">
            <i class="fa-solid fa-user-plus text-indigo-600 dark:text-indigo-400"></i>
            <span>Ajouter un <span class="gradient-text">Stagiaire</span></span>
        </h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Créez un nouveau profil stagiaire et attribuez ses accès système</p>
    </div>

    <div class="glass-panel rounded-2xl p-6 sm:p-8 max-w-2xl border border-slate-200 dark:border-slate-800 shadow-xl bg-white dark:bg-slate-900/80">
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-300 rounded-xl text-xs sm:text-sm">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> Veuillez corriger les erreurs ci-dessous :
                </div>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('encadrant.stagiaires.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Sexe *</label>
                    <select name="sexe" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl text-slate-900 dark:text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Homme (M)</option>
                        <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Femme (F)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Filière</label>
                    <select name="filiere" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl text-slate-900 dark:text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="ID1" {{ old('filiere') == 'ID1' ? 'selected' : '' }}>ID1</option>
                        <option value="ID2" {{ old('filiere') == 'ID2' ? 'selected' : '' }}>ID2</option>
                        <option value="ID3" {{ old('filiere') == 'ID3' ? 'selected' : '' }}>ID3</option>
                        <option value="AS" {{ old('filiere') == 'AS' ? 'selected' : '' }}>AS</option>
                        <option value="IDE1" {{ old('filiere') == 'IDE1' ? 'selected' : '' }}>IDE1</option>
                        <option value="IDE2" {{ old('filiere') == 'IDE2' ? 'selected' : '' }}>IDE2</option>
                        <option value="IDE3" {{ old('filiere') == 'IDE3' ? 'selected' : '' }}>IDE3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Nom de famille"
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required placeholder="Prénom"
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Date de naissance</label>
                    <input type="date" name="naissance" value="{{ old('naissance') }}" 
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" placeholder="Ex: Yaoundé"
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Téléphone</label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: 699000000"
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="stagiaire@domaine.cm"
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Mot de passe initial (optionnel)</label>
                    <input type="text" name="password" value="{{ old('password', 'stagiaire123') }}" 
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                    <p class="text-[10px] text-slate-400 mt-1">Par défaut : stagiaire123 (modifiable par le stagiaire)</p>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Lieu de stage</label>
                    <select name="lieu" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl text-slate-900 dark:text-slate-100 text-sm focus:outline-none focus:border-indigo-500">
                        <option value="Hôpital Régional" {{ old('lieu') == 'Hôpital Régional' ? 'selected' : '' }}>Hôpital Régional</option>
                        <option value="Hôpital de District" {{ old('lieu') == 'Hôpital de District' ? 'selected' : '' }}>Hôpital de District</option>
                        <option value="CMA TYO" {{ old('lieu') == 'CMA TYO' ? 'selected' : '' }}>CMA TYO</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Photo d'identité</label>
                    <input type="file" name="photo" accept="image/*" 
                           class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700/80 rounded-xl p-2 text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                </div>
            </div>

            <div class="pt-3 flex items-center gap-3">
                <button type="submit" class="gradient-bg-primary hover:opacity-95 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-600/30 transition text-sm flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Enregistrer le Stagiaire</span>
                </button>
                <a href="{{ route('encadrant.stagiaires.index') }}" 
                   class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700 px-5 py-3 rounded-xl text-sm font-medium transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
