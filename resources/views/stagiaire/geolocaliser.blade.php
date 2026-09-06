@extends('layouts.app')
@section('title', 'Ma localisation')

@section('sidebar')
    <div class="px-2 mb-3">
        <p class="text-xs uppercase font-bold tracking-wider text-slate-400">Espace Stagiaire</p>
    </div>
    <a href="{{ route('stagiaire.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 text-sm font-medium transition">
        <i class="fa-solid fa-house text-indigo-400"></i> Mon Espace
    </a>
    <a href="{{ route('stagiaire.geolocaliser') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-600/30 text-white border border-indigo-500/30 text-sm font-semibold transition">
        <i class="fa-solid fa-location-crosshairs text-indigo-400"></i> Ma Localisation
    </a>
@endsection

@section('content')
<div class="space-y-6 max-w-xl">
    <div>
        <h1 class="text-2xl font-bold text-slate-100 flex items-center gap-3">
            <i class="fa-solid fa-location-crosshairs text-indigo-400"></i> Ma Localisation GPS
        </h1>
        <p class="text-slate-400 text-sm mt-1">Transmettez vos coordonnées GPS à votre encadrant</p>
    </div>

    <div class="glass-panel p-6 sm:p-8 rounded-2xl space-y-6">
        <p class="text-sm text-slate-300 leading-relaxed">
            Cliquez sur le bouton ci-dessous pour capturer et enregistrer votre position géographique actuelle.
        </p>

        @if($stagiaire->latitude)
            <div class="glass-card p-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 text-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <div>
                    <p class="font-bold">Dernière position enregistrée :</p>
                    <p class="font-mono text-xs mt-0.5">{{ $stagiaire->latitude }}, {{ $stagiaire->longitude }}</p>
                </div>
            </div>
        @endif

        <button id="geoBtn"
                class="w-full gradient-bg-primary text-white py-3.5 px-6 rounded-xl font-bold hover:opacity-95 shadow-lg shadow-indigo-500/25 transition flex items-center justify-center gap-3 text-sm">
            <i class="fa-solid fa-location-arrow text-base"></i> Localiser ma position
        </button>

        <p id="status" class="text-center text-sm font-medium text-slate-400"></p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('geoBtn').addEventListener('click', function() {
    const status = document.getElementById('status');
    if (!navigator.geolocation) {
        status.textContent = 'Géolocalisation non supportée par votre navigateur.';
        status.className = 'text-center text-sm font-medium text-rose-400';
        return;
    }
    status.textContent = 'Capture de la position GPS en cours...';
    status.className = 'text-center text-sm font-medium text-indigo-400 animate-pulse';
    navigator.geolocation.getCurrentPosition(function(pos) {
        fetch('{{ route("stagiaire.position.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                stagiaire_id: {{ $stagiaire->id }},
                latitude: pos.coords.latitude,
                longitude: pos.coords.longitude
            })
        })
        .then(r => r.json())
        .then(data => {
            status.textContent = data.success ?? data.error;
            status.className = data.success ? 'text-center text-sm font-bold text-emerald-400' : 'text-center text-sm font-bold text-rose-400';
        });
    }, function() {
        status.textContent = 'Impossible d\'obtenir la position GPS.';
        status.className = 'text-center text-sm font-medium text-rose-400';
    });
});
</script>
@endpush
