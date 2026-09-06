@extends('layouts.app')
@section('title', 'Tableau de bord Encadrant')

@section('sidebar')
    @include('encadrant.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-chart-pie text-indigo-400"></i>
                <span>Tableau de bord <span class="gradient-text">Encadrant</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Aperçu global de l'activité des stagiaires et des candidatures</p>
        </div>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('encadrant.presences.create') }}" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-600/20 transition">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Pointer Présence</span>
            </a>
            <a href="{{ route('encadrant.stagiaires.create') }}" 
               class="inline-flex items-center gap-2 gradient-bg-primary hover:opacity-95 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition">
                <i class="fa-solid fa-user-plus"></i>
                <span>Nouveau Stagiaire</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Metric Card 1 -->
        <div class="glass-panel p-5 rounded-2xl border border-slate-800 relative overflow-hidden group hover:border-indigo-500/50 transition duration-300">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Stagiaires Actifs</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl sm:text-4xl font-extrabold text-white">{{ $stagiaires->count() }}</span>
                <span class="text-xs text-indigo-400 font-medium bg-indigo-500/10 px-2 py-0.5 rounded-md">Total inscrits</span>
            </div>
        </div>

        <!-- Metric Card 2 -->
        <div class="glass-panel p-5 rounded-2xl border border-slate-800 relative overflow-hidden group hover:border-amber-500/50 transition duration-300">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Demandes en attente</span>
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-clock font-bold"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl sm:text-4xl font-extrabold text-amber-400">{{ $demandes->where('etat', 'En attente')->count() }}</span>
                <span class="text-xs text-amber-300 font-medium bg-amber-500/10 px-2 py-0.5 rounded-md">À traiter</span>
            </div>
        </div>

        <!-- Metric Card 3 -->
        <div class="glass-panel p-5 rounded-2xl border border-slate-800 relative overflow-hidden group hover:border-emerald-500/50 transition duration-300 sm:col-span-2 lg:col-span-1">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Demandes Validées</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl sm:text-4xl font-extrabold text-emerald-400">{{ $demandes->where('etat', 'Validée')->count() }}</span>
                <span class="text-xs text-emerald-300 font-medium bg-emerald-500/10 px-2 py-0.5 rounded-md">Acceptées</span>
            </div>
        </div>
    </div>

    <!-- Recent Demandes Section -->
    <div class="glass-panel rounded-2xl p-5 border border-slate-800 shadow-xl">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-inbox text-indigo-400"></i> Demandes de stage récentes
                </h2>
                <p class="text-xs text-slate-400">Dernières postulations soumises via la plateforme</p>
            </div>
            <a href="{{ route('encadrant.demandes.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 flex items-center gap-1 transition">
                <span>Voir tout</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($demandes->isEmpty())
            <div class="text-center py-8 text-slate-400">
                <i class="fa-solid fa-folder-open text-3xl mb-2 opacity-50"></i>
                <p class="text-sm">Aucune demande enregistrée pour le moment.</p>
            </div>
        @else
            <!-- Responsive Table Container -->
            <div class="overflow-x-auto rounded-xl border border-slate-800/80">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-900/90 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="px-4 py-3.5">Candidat</th>
                            <th class="px-4 py-3.5">Filière</th>
                            <th class="px-4 py-3.5">Lieu</th>
                            <th class="px-4 py-3.5 text-center">État</th>
                            <th class="px-4 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-slate-300">
                        @foreach($demandes as $d)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="px-4 py-3 font-semibold text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 text-indigo-400 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($d->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-100">{{ $d->nom }} {{ $d->prenom }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $d->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-300">{{ $d->filiere }}</td>
                            <td class="px-4 py-3 text-slate-300">
                                <span class="inline-flex items-center gap-1 text-slate-400 text-xs">
                                    <i class="fa-solid fa-location-dot text-slate-500"></i> {{ $d->lieu }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($d->etat === 'Validée')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i> Validée
                                    </span>
                                @elseif($d->etat === 'Refusée')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        <i class="fa-solid fa-circle-xmark text-[10px]"></i> Refusée
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        <i class="fa-solid fa-clock text-[10px]"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('encadrant.demandes.show', $d) }}"
                                   class="inline-flex items-center gap-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium border border-slate-700 transition">
                                    <i class="fa-solid fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

