@extends('layouts.app')
@section('title', 'Nouveau Encadrant')

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
<div class="space-y-6 max-w-2xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
                <i class="fa-solid fa-user-plus text-indigo-400"></i> Ajouter un Encadrant
            </h1>
            <p class="text-slate-400 text-sm mt-1">Créez un nouveau compte d'accès Encadrant</p>
        </div>
        <a href="{{ route('admin.encadrants.index') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 px-4 py-2 rounded-xl text-sm font-semibold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-800">
        <form action="{{ route('admin.encadrants.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Nom et Prénom *</label>
                <input type="text" name="nom" required placeholder="Ex: Dr. Martin NANA" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Adresse Email *</label>
                <input type="email" name="email" required placeholder="encadrant@institution.cm" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Matricule (Optionnel - généré automatiquement si vide)</label>
                <input type="text" name="matricule" placeholder="Ex: ENC20260001" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500 font-mono">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-200 mb-2">Mot de passe de connexion *</label>
                <input type="password" name="password" required minlength="6" placeholder="Saisir au moins 6 caractères..." class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-100 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                <a href="{{ route('admin.encadrants.index') }}" class="px-5 py-3 rounded-xl font-semibold border border-slate-700 text-slate-300 hover:bg-slate-800 text-sm transition">
                    Annuler
                </a>
                <button type="submit" class="gradient-bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:opacity-90 shadow-lg text-sm transition">
                    Créer le Compte Encadrant
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
