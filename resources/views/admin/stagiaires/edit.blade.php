@extends('layouts.app')
@section('title', 'Modifier Stagiaire')

@section('sidebar')
<div class="px-3 py-2 mb-2">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Administration</p>
</div>
<div class="space-y-1 font-medium text-sm">
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-chart-line w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
        <span>Tableau de bord</span>
    </a>
    <a href="{{ route('admin.users.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-users-gear w-5 text-center text-base {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-purple-400' }}"></i>
        <span>Tous les Comptes</span>
    </a>
    <a href="{{ route('admin.encadrants.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.encadrants.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-user-shield w-5 text-center text-base {{ request()->routeIs('admin.encadrants.*') ? 'text-white' : 'text-amber-400' }}"></i>
        <span>Gestion Encadrants</span>
    </a>
    <a href="{{ route('admin.stagiaires.index') }}" 
       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition duration-150 {{ request()->routeIs('admin.stagiaires.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
        <i class="fa-solid fa-user-graduate w-5 text-center text-base {{ request()->routeIs('admin.stagiaires.*') ? 'text-white' : 'text-emerald-400' }}"></i>
        <span>Gestion Stagiaires</span>
    </a>
</div>
@endsection

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-user-pen text-indigo-400"></i> Modifier le Stagiaire
            </h1>
            <p class="text-slate-400 text-sm mt-1">Modification du profil de {{ $stagiaire->nom_complet }}</p>
        </div>
        <a href="{{ route('admin.stagiaires.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('admin.stagiaires.update', $stagiaire) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $stagiaire->nom) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $stagiaire->prenom) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Sexe *</label>
                    <select name="sexe" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="M" {{ old('sexe', $stagiaire->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe', $stagiaire->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Adresse Email *</label>
                    <input type="email" name="email" value="{{ old('email', $stagiaire->email) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $stagiaire->telephone) }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 font-mono">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Filière / Spécialité</label>
                    <input type="text" name="filiere" value="{{ old('filiere', $stagiaire->filiere) }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Date de naissance</label>
                    <input type="date" name="naissance" value="{{ old('naissance', $stagiaire->naissance ? \Carbon\Carbon::parse($stagiaire->naissance)->format('Y-m-d') : '') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $stagiaire->lieu_naissance) }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Lieu / Ville de résidence</label>
                    <input type="text" name="lieu" value="{{ old('lieu', $stagiaire->lieu) }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-200 mb-2">Changer la Photo de profil</label>
                    <input type="file" name="photo" accept="image/*" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-300 text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Nouveau Mot de passe (Laissez vide pour conserver l'actuel)</label>
                <input type="password" name="password" minlength="6" placeholder="Nouveau mot de passe..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.stagiaires.index') }}" class="px-5 py-3 rounded-xl font-semibold border border-slate-700 text-slate-300 hover:bg-slate-800 text-sm transition">
                    Annuler
                </a>
                <button type="submit" class="gradient-bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:opacity-90 shadow-lg text-sm transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
