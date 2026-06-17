@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('sidebar')
    <p class="text-xs uppercase text-purple-300 mb-3 px-2">Admin</p>
    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">📊 Dashboard</a>
    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded hover:bg-purple-700 text-sm">👤 Utilisateurs</a>
@endsection

@section('content')
<h1 class="text-2xl font-bold text-purple-900 mb-6">Tableau de bord Administrateur</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-600">
        <p class="text-sm text-gray-500">Utilisateurs</p>
        <p class="text-3xl font-bold text-purple-800">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Stagiaires actifs</p>
        <p class="text-3xl font-bold text-blue-700">{{ $totalStagiaires }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Taux de présence global</p>
        <p class="text-3xl font-bold text-green-700">{{ $attendanceRate }}%</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Présences chart -->
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Présences par stagiaire</h2>
        <canvas id="presencesChart" height="200"></canvas>
    </div>

    <!-- Demandes chart -->
    <div class="bg-white rounded-xl shadow p-5">
        <h2 class="font-semibold text-gray-700 mb-4">Demandes de stage</h2>
        <canvas id="demandesChart" height="200"></canvas>
        <div class="mt-4 grid grid-cols-3 text-center text-sm">
            <div><span class="font-bold text-yellow-600">{{ $demandesAttente }}</span><br>En attente</div>
            <div><span class="font-bold text-green-600">{{ $demandesValidees }}</span><br>Validées</div>
            <div><span class="font-bold text-red-600">{{ $demandesRefusees }}</span><br>Refusées</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const presencesCtx = document.getElementById('presencesChart').getContext('2d');
    new Chart(presencesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($presencesData->pluck('nom')) !!},
            datasets: [{
                label: 'Taux de présence (%)',
                data: {!! json_encode($presencesData->pluck('rate')) !!},
                backgroundColor: '#7c3aed',
            }]
        },
        options: { responsive: true, scales: { y: { max: 100 } } }
    });

    const demandesCtx = document.getElementById('demandesChart').getContext('2d');
    new Chart(demandesCtx, {
        type: 'pie',
        data: {
            labels: ['En attente', 'Validées', 'Refusées'],
            datasets: [{
                data: [{{ $demandesAttente }}, {{ $demandesValidees }}, {{ $demandesRefusees }}],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
            }]
        },
    });
</script>
@endpush
