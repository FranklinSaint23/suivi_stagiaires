@extends('layouts.app')
@section('title', 'Dashboard Administrateur')

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
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-gauge-high text-indigo-400"></i>
                <span>Tableau de bord <span class="gradient-text">Administrateur</span></span>
            </h1>
            <p class="text-sm text-slate-400 mt-1">Supervision du système, utilisateurs et statistiques globales</p>
        </div>

        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center gap-2 gradient-bg-primary hover:opacity-95 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition">
            <i class="fa-solid fa-user-gear"></i>
            <span>Gérer Utilisateurs</span>
        </a>
    </div>

    {{-- Reset Password Requests Alert --}}
    @if(isset($resetRequests) && $resetRequests->count() > 0)
    <div class="glass-panel border border-amber-500/40 bg-amber-500/10 rounded-2xl p-5 shadow-xl space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-amber-300 text-sm sm:text-base flex items-center gap-2">
                <i class="fa-solid fa-bell text-amber-400 animate-bounce"></i>
                Demandes de réinitialisation de mot de passe en attente ({{ $resetRequests->count() }})
            </h3>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-amber-400 hover:underline font-semibold">Gérer dans Utilisateurs →</a>
        </div>
        <div class="divide-y divide-amber-500/20">
            @foreach($resetRequests as $req)
                <div class="py-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs sm:text-sm">
                    <div>
                        <p class="font-bold text-slate-100">{{ $req->message }}</p>
                        <p class="text-slate-400 text-xs mt-0.5"><i class="fa-regular fa-clock mr-1"></i> {{ $req->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="bg-amber-500/20 hover:bg-amber-500/30 text-amber-200 border border-amber-500/30 px-3 py-1.5 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1.5 self-start sm:self-auto">
                        <i class="fa-solid fa-key"></i> Réinitialiser mdp
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="glass-panel p-5 rounded-2xl border border-slate-800 relative overflow-hidden group hover:border-purple-500/50 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Utilisateurs Totaux</span>
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-extrabold text-white">{{ $totalUsers }}</div>
        </div>

        <div class="glass-panel p-5 rounded-2xl border border-slate-800 relative overflow-hidden group hover:border-indigo-500/50 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Stagiaires Actifs</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-extrabold text-indigo-400">{{ $totalStagiaires }}</div>
        </div>

        <div class="glass-panel p-5 rounded-2xl border border-slate-800 relative overflow-hidden group hover:border-emerald-500/50 transition duration-300">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Taux de Présence</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-extrabold text-emerald-400">{{ $attendanceRate }}%</div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-panel rounded-2xl p-5 border border-slate-800 shadow-xl">
            <h2 class="font-bold text-slate-100 text-lg mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-column text-indigo-400"></i> Taux de présence par stagiaire
            </h2>
            <div class="relative h-64">
                <canvas id="presencesChart"></canvas>
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-5 border border-slate-800 shadow-xl flex flex-col justify-between">
            <div>
                <h2 class="font-bold text-slate-100 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-purple-400"></i> Répartition des demandes
                </h2>
                <div class="relative h-48 flex justify-center">
                    <canvas id="demandesChart"></canvas>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-800 grid grid-cols-3 text-center text-xs gap-2">
                <div class="p-2 bg-amber-500/10 border border-amber-500/20 rounded-xl">
                    <span class="font-bold text-amber-400 text-lg block">{{ $demandesAttente }}</span>
                    <span class="text-slate-400">En attente</span>
                </div>
                <div class="p-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                    <span class="font-bold text-emerald-400 text-lg block">{{ $demandesValidees }}</span>
                    <span class="text-slate-400">Validées</span>
                </div>
                <div class="p-2 bg-rose-500/10 border border-rose-500/20 rounded-xl">
                    <span class="font-bold text-rose-400 text-lg block">{{ $demandesRefusees }}</span>
                    <span class="text-slate-400">Refusées</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.08)';

    const presencesCtx = document.getElementById('presencesChart').getContext('2d');
    new Chart(presencesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($presencesData->pluck('nom')) !!},
            datasets: [{
                label: 'Taux de présence (%)',
                data: {!! json_encode($presencesData->pluck('rate')) !!},
                backgroundColor: '#6366f1',
                borderRadius: 8,
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { max: 100, grid: { color: 'rgba(255, 255, 255, 0.05)' } } } 
        }
    });

    const demandesCtx = document.getElementById('demandesChart').getContext('2d');
    new Chart(demandesCtx, {
        type: 'doughnut',
        data: {
            labels: ['En attente', 'Validées', 'Refusées'],
            datasets: [{
                data: [{{ $demandesAttente }}, {{ $demandesValidees }}, {{ $demandesRefusees }}],
                backgroundColor: ['#f59e0b', '#10b981', '#f43f5e'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush

